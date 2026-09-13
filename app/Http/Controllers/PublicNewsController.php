<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Category;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('kategori');
        $search = trim((string) $request->query('q', ''));
        $isSearching = $search !== '';

        // Filter yang dipakai bersama oleh semua query konten
        $applyFilters = fn ($q) => $q
            ->when($categorySlug, fn ($qq) => $qq->category($categorySlug))
            ->when($isSearching, fn ($qq) => $qq->where(function ($wq) use ($search) {
                $wq->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            }));

        $berita = Berita::published()
            ->with(['category', 'penulis', 'images'])
            ->tap($applyFilters)
            // Saat mencari/menyaring, hero disembunyikan sehingga hasilnya tidak terpotong
            ->when(!$isSearching && !$categorySlug, fn ($q) => $q->skip(1))
            ->latest('published_at')
            ->paginate(9, ['*'], 'berita_page')
            ->withQueryString();

        $artikel = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->tap($applyFilters)
            ->latest('published_at')
            ->paginate(9, ['*'], 'artikel_page')
            ->withQueryString();

        $categories = Category::all();

        // Hero hanya tampil di beranda tanpa filter/pencarian (ID di-cache 10 menit)
        $heroBerita = null;
        $featuredItems = collect();

        if (!$isSearching && !$categorySlug) {
            $heroId = \Illuminate\Support\Facades\Cache::remember('home_hero_id', 600, fn () =>
                Berita::published()->latest('published_at')->value('id')
            );

            $heroBerita = $heroId
                ? Berita::published()->with(['category', 'penulis', 'images'])->find($heroId)
                : null;

            // ->all() agar yang di-cache array primitif, bukan objek Collection
            $featuredIds = \Illuminate\Support\Facades\Cache::remember('home_featured_ids', 600, fn () =>
                Berita::published()
                    ->when($heroId, fn ($q) => $q->where('id', '!=', $heroId))
                    ->latest('published_at')
                    ->take(4)
                    ->pluck('id')
                    ->all()
            );

            $featuredItems = Berita::published()
                ->with(['category', 'penulis', 'images'])
                ->whereIn('id', $featuredIds)
                ->latest('published_at')
                ->get();
        }

        $mustReadIds = \Illuminate\Support\Facades\Cache::remember('home_must_read_ids', 600, fn () =>
            Artikel::published()->latest('published_at')->take(3)->pluck('id')->all()
        );

        $mustRead = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->whereIn('id', $mustReadIds)
            ->latest('published_at')
            ->get();

        // Konten paling populer berdasarkan jumlah tayangan
        $popular = Berita::published()
            ->with(['category', 'images'])
            ->orderByDesc('views')
            ->take(4)
            ->get(['id', 'category_id', 'title', 'slug', 'views', 'published_at'])
            ->map(fn ($b) => [
                'title' => $b->title,
                'slug' => $b->slug,
                'views' => $b->views,
                'category' => $b->category?->name,
                'published_at' => $b->published_at,
                'image' => $b->images->first()?->url,
                'route' => route('public.berita.show', $b->slug),
                'type' => 'Berita',
            ])
            ->concat(
                Artikel::published()
                    ->with(['category', 'images'])
                    ->orderByDesc('views')
                    ->take(4)
                    ->get(['id', 'category_id', 'title', 'slug', 'views', 'published_at'])
                    ->map(fn ($a) => [
                        'title' => $a->title,
                        'slug' => $a->slug,
                        'views' => $a->views,
                        'category' => $a->category?->name,
                        'published_at' => $a->published_at,
                        'image' => $a->images->first()?->url,
                        'route' => route('public.artikel.show', $a->slug),
                        'type' => 'Artikel',
                    ])
            )
            ->sortByDesc('views')
            ->take(4)
            ->values();

        $creatorIds = \Illuminate\Support\Facades\Cache::remember('home_creator_ids', 600, fn () =>
            \App\Models\User::whereHas('beritaDitulis', fn ($q) => $q->published())
                ->withCount(['beritaDitulis' => fn ($q) => $q->published()])
                ->orderByDesc('berita_ditulis_count')
                ->take(4)
                ->pluck('id')
                ->all()
        );

        $creators = \App\Models\User::whereIn('id', $creatorIds)
            ->withCount(['beritaDitulis' => fn ($q) => $q->published()])
            ->orderByDesc('berita_ditulis_count')
            ->get();

        return view('public.index', compact(
            'berita', 'artikel', 'categories', 'categorySlug', 'search', 'isSearching',
            'heroBerita', 'featuredItems', 'mustRead', 'popular', 'creators'
        ));
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255', 'unique:subscribers,email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar sebagai pelanggan.',
        ]);

        Subscriber::create($validated);

        return back()->with('newsletter_success', 'Berhasil! Anda kini terdaftar sebagai pelanggan NewsHub.');
    }

    public function sitemap()
    {
        $berita = Berita::published()->latest('published_at')->get(['slug', 'published_at', 'updated_at']);
        $artikel = Artikel::published()->latest('published_at')->get(['slug', 'published_at', 'updated_at']);

        return response()
            ->view('public.sitemap', compact('berita', 'artikel'))
            ->header('Content-Type', 'application/xml');
    }

    public function feed()
    {
        $berita = Berita::published()->with('category')->latest('published_at')->take(20)->get();
        $artikel = Artikel::published()->with('category')->latest('published_at')->take(20)->get();

        $items = $berita->map(fn ($b) => [
            'title' => $b->title,
            'link' => route('public.berita.show', $b->slug),
            'description' => $b->excerpt,
            'category' => $b->category?->name,
            'date' => $b->published_at,
        ])->concat($artikel->map(fn ($a) => [
            'title' => $a->title,
            'link' => route('public.artikel.show', $a->slug),
            'description' => $a->excerpt,
            'category' => $a->category?->name,
            'date' => $a->published_at,
        ]))->sortByDesc('date')->take(20)->values();

        return response()
            ->view('public.feed', ['items' => $items])
            ->header('Content-Type', 'application/rss+xml');
    }

    public function page(string $slug)
    {
        $pages = [
            'tentang-kami' => ['title' => 'Tentang Kami'],
            'karier' => ['title' => 'Karier'],
            'media-kit' => ['title' => 'Media Kit'],
            'kontak' => ['title' => 'Kontak'],
            'faq' => ['title' => 'FAQ'],
            'kebijakan-privasi' => ['title' => 'Kebijakan Privasi'],
            'syarat-ketentuan' => ['title' => 'Syarat & Ketentuan'],
        ];

        abort_unless(isset($pages[$slug]), 404);

        return view('public.page', ['title' => $pages[$slug]['title'], 'slug' => $slug]);
    }

    public function showBerita(string $slug)
    {
        $berita = Berita::published()
            ->with(['category', 'penulis', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Hitung tayangan sekali per sesi agar refresh tidak menggembungkan angka
        if (!session()->has("viewed_berita.{$berita->id}")) {
            $berita->increment('views');
            session()->put("viewed_berita.{$berita->id}", true);
        }

        $related = Berita::published()
            ->with(['category', 'images'])
            ->where('id', '!=', $berita->id)
            ->when($berita->category_id, fn ($q) => $q->where('category_id', $berita->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        // Fallback: kalau kategori ini belum punya berita lain, ambil yang terbaru
        if ($related->isEmpty()) {
            $related = Berita::published()
                ->with(['category', 'images'])
                ->where('id', '!=', $berita->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('public.berita-show', compact('berita', 'related'));
    }

    public function showArtikel(string $slug)
    {
        $artikel = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        if (!session()->has("viewed_artikel.{$artikel->id}")) {
            $artikel->increment('views');
            session()->put("viewed_artikel.{$artikel->id}", true);
        }

        $related = Artikel::published()
            ->with(['category', 'images'])
            ->where('id', '!=', $artikel->id)
            ->when($artikel->category_id, fn ($q) => $q->where('category_id', $artikel->category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->isEmpty()) {
            $related = Artikel::published()
                ->with(['category', 'images'])
                ->where('id', '!=', $artikel->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('public.artikel-show', compact('artikel', 'related'));
    }
}
