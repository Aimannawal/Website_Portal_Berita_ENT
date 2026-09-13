<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Category;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::with(['category', 'creator'])->latest()->paginate(15);

        return view('berita.index', compact('berita'));
    }

    public function create()
    {
        $categories = Category::where('type', 'berita')->get();
        $users = User::orderBy('name')->get();

        return view('berita.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $berita = Berita::create([
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
            $berita->penulis()->attach($data['penulis']);
        }

        $this->storeImages($berita, $request);

        return redirect()->route('pk.berita.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(Berita $berita)
    {
        $categories = Category::where('type', 'berita')->get();
        $users = User::orderBy('name')->get();
        $berita->load('penulis', 'images');

        return view('berita.edit', compact('berita', 'categories', 'users'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validateData($request);

        $berita->update([
            'category_id'  => $data['category_id'] ?? null,
            'title'        => $data['title'],
            'excerpt'      => $data['excerpt'] ?? null,
            'content'      => $data['content'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($berita->published_at ?? now()) : null,
        ]);

        $berita->penulis()->sync($data['penulis'] ?? []);

        $this->storeImages($berita, $request);

        return redirect()->route('pk.berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Berita $berita)
    {
        foreach ($berita->images as $image) {
            Storage::disk('public')->delete($image->file_path);
        }
        $berita->delete();

        return redirect()->route('pk.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function destroyImage(Berita $berita, Media $media)
    {
        abort_if($media->mediable_id !== $berita->id || $media->mediable_type !== Berita::class, 404);

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

    private function storeImages(Berita $berita, Request $request): void
    {
        $files = $request->file('images', []);

        if (!$request->hasFile('images') || !is_array($files)) {
            return;
        }

        $order = ($berita->images()->max('order') ?? -1) + 1;

        foreach ($files as $file) {
            $path = Storage::disk('public')->putFile('berita', $file);

            if ($path === false) {
                throw new \RuntimeException('Gambar berita gagal disimpan ke storage.');
            }

            $berita->images()->create([
                'file_path'     => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'order'         => $order++,
            ]);
        }
    }
}
