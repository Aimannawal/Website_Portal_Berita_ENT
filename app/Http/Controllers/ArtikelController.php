<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['category', 'creator'])->latest()->paginate(15);

        return view('artikel.index', compact('artikel'));
    }

    public function create()
    {
        $categories = Category::where('type', 'artikel')->get();
        $users = User::orderBy('name')->get();

        return view('artikel.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $artikel = Artikel::create([
            'category_id'  => $data['category_id'] ?? null,
            'created_by'   => Auth::id(),
            'title'        => $data['title'],
            'slug'         => Str::slug($data['title']) . '-' . Str::random(5),
            'excerpt'      => $data['excerpt'] ?? null,
            'content'      => $data['content'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);

        if (!empty($data['penulis'])) {
            $artikel->penulis()->attach($data['penulis']);
        }

        $this->storeImages($artikel, $request);

        return redirect()->route('pk.artikel.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Artikel $artikel)
    {
        $categories = Category::where('type', 'artikel')->get();
        $users = User::orderBy('name')->get();
        $artikel->load('penulis', 'images');

        return view('artikel.edit', compact('artikel', 'categories', 'users'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $data = $this->validateData($request);

        $artikel->update([
            'category_id'  => $data['category_id'] ?? null,
            'title'        => $data['title'],
            'excerpt'      => $data['excerpt'] ?? null,
            'content'      => $data['content'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($artikel->published_at ?? now()) : null,
        ]);

        $artikel->penulis()->sync($data['penulis'] ?? []);

        $this->storeImages($artikel, $request);

        return redirect()->route('pk.artikel.index')->with('success', 'Artikel berhasil diupdate.');
    }

    public function destroy(Artikel $artikel)
    {
        foreach ($artikel->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }
        $artikel->delete();

        return redirect()->route('pk.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function destroyImage(Artikel $artikel, Media $media)
    {
        abort_if($media->mediable_id !== $artikel->id || $media->mediable_type !== Artikel::class, 404);

        Storage::disk('public')->delete($media->file_path);
        $media->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'excerpt'     => ['nullable', 'string'],
            'content'     => ['required', 'string'],
            'status'      => ['required', 'in:draft,review,published'],
            'penulis'     => ['nullable', 'array'],
            'penulis.*'   => ['exists:users,id'],
            'images'      => ['nullable', 'array'],
            'images.*'    => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);
    }

    private function storeImages(Artikel $artikel, Request $request): void
    {
        $files = $request->file('images', []);

        if (!$request->hasFile('images') || !is_array($files)) {
            return;
        }

        $order = ($artikel->images()->max('order') ?? -1) + 1;

        foreach ($files as $file) {
            $path = Storage::disk('public')->putFile('artikel', $file);

            if ($path === false) {
                throw new \RuntimeException('Gambar artikel gagal disimpan ke storage.');
            }

            $artikel->images()->create([
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'order'         => $order++,
            ]);
        }
    }
}
