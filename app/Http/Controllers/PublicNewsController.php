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

        // Hero hanya tampil di beranda tanpa filter/pencarian
        $heroBerita = null;
        $featuredItems = collect();

        if (!$isSearching && !$categorySlug) {
            $heroBerita = Berita::published()
                ->with(['category', 'penulis', 'images'])
                ->latest('published_at')
                ->first();

            $featuredItems = Berita::published()
                ->with(['category', 'penulis', 'images'])
                ->when($heroBerita, fn ($q) => $q->where('id', '!=', $heroBerita->id))
                ->latest('published_at')
                ->take(4)
                ->get();
        }

        $mustRead = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->latest('published_at')
            ->take(3)
            ->get();

        $creators = \App\Models\User::whereHas('beritaDitulis', fn ($q) => $q->published())
            ->withCount(['beritaDitulis' => fn ($q) => $q->published()])
            ->orderByDesc('berita_ditulis_count')
            ->take(4)
            ->get();

        return view('public.index', compact(
            'berita', 'artikel', 'categories', 'categorySlug', 'search', 'isSearching',
            'heroBerita', 'featuredItems', 'mustRead', 'creators'
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
