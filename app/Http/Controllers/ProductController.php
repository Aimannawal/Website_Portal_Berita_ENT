<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->makeUniqueSlug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->storeThumbnail($request);
        }

        Product::create($data);

        return redirect()->route('pk.products.index')->with('success', 'Product berhasil dibuat.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request);

        if ($product->title !== $data['title']) {
            $data['slug'] = $this->makeUniqueSlug($data['title'], $product);
        }

        if ($request->hasFile('thumbnail')) {
            $this->deleteThumbnail($product);
            $data['thumbnail'] = $this->storeThumbnail($request);
        }

        $product->update($data);

        return redirect()->route('pk.products.index')->with('success', 'Product berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $this->deleteThumbnail($product);
        $product->delete();

        return redirect()->route('pk.products.index')->with('success', 'Product berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'link' => ['required', 'url', 'max:2048'],
            'thumbnail' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);
    }

    private function makeUniqueSlug(string $title, ?Product $ignore = null): string
    {
        $baseSlug = Str::slug($title) ?: 'product';
        $slug = $baseSlug;
        $counter = 2;

        while (Product::where('slug', $slug)
            ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter++;
        }

        return $slug;
    }

    private function storeThumbnail(Request $request): string
    {
        $path = Storage::disk('public')->putFile('products', $request->file('thumbnail'));

        if ($path === false) {
            throw new \RuntimeException('Thumbnail product gagal disimpan ke storage.');
        }

        return $path;
    }

    private function deleteThumbnail(Product $product): void
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }
    }
}
