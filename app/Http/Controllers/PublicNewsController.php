<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Berita;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicNewsController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('kategori');

        $berita = Berita::published()
            ->with(['category', 'penulis'])
            ->when($categorySlug, fn ($q) => $q->category($categorySlug))
            ->latest('published_at')
            ->paginate(9, ['*'], 'berita_page');

        $artikel = Artikel::published()
            ->with(['category', 'penulis'])
            ->when($categorySlug, fn ($q) => $q->category($categorySlug))
            ->latest('published_at')
            ->paginate(9, ['*'], 'artikel_page');

        $categories = Category::all();

        // Konten untuk hero, sidebar, dan section-section halaman depan
        $heroBerita = Berita::published()
            ->with(['category', 'penulis', 'images'])
            ->when($categorySlug, fn ($q) => $q->category($categorySlug))
            ->latest('published_at')
            ->first();

        $featuredItems = Berita::published()
            ->with(['category', 'penulis', 'images'])
            ->when($categorySlug, fn ($q) => $q->category($categorySlug))
            ->latest('published_at')
            ->when($heroBerita, fn ($q) => $q->where('id', '!=', $heroBerita->id))
            ->take(4)
            ->get();

        $mustRead = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->when($categorySlug, fn ($q) => $q->category($categorySlug))
            ->latest('published_at')
            ->take(3)
            ->get();

        $creators = \App\Models\User::whereHas('beritaDitulis', fn ($q) => $q->published())
            ->withCount(['beritaDitulis' => fn ($q) => $q->published()])
            ->orderByDesc('berita_ditulis_count')
            ->take(4)
            ->get();

        return view('public.index', compact(
            'berita', 'artikel', 'categories', 'categorySlug',
            'heroBerita', 'featuredItems', 'mustRead', 'creators'
        ));
    }

    public function showBerita(string $slug)
    {
        $berita = Berita::published()
            ->with(['category', 'penulis', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.berita-show', compact('berita'));
    }

    public function showArtikel(string $slug)
    {
        $artikel = Artikel::published()
            ->with(['category', 'penulis', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.artikel-show', compact('artikel'));
    }
}
