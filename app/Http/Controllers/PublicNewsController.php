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

        return view('public.index', compact('berita', 'artikel', 'categories', 'categorySlug'));
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
