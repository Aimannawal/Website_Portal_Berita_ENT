@extends('layouts.app')
@section('title', 'Edit Berita')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Berita: {{ $berita->title }}</h1>

<form id="content-form" action="{{ route('pk.berita.update', $berita) }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-2xl space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title', $berita->title) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="category_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $berita->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Ringkasan (excerpt)</label>
        <textarea name="excerpt" rows="2" class="w-full border rounded px-3 py-2">{{ old('excerpt', $berita->excerpt) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Isi Berita</label>
        <div id="editor" style="height: 250px;" class="bg-white"></div>
        <textarea name="content" id="content" class="hidden">{{ old('content', $berita->content) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Penulis (bisa pilih lebih dari satu)</label>
        <select name="penulis[]" multiple class="w-full border rounded px-3 py-2 h-32">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected($berita->penulis->contains($user->id))>
                    {{ $user->name }} ({{ $user->division?->name }})
                </option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Tahan Ctrl/Cmd untuk memilih lebih dari satu.</p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Gambar Saat Ini</label>
        <div class="flex flex-wrap gap-3">
            @forelse ($berita->images as $image)
                <div class="relative">
                    <img src="{{ asset('storage/' . $image->file_path) }}" class="w-24 h-24 object-cover rounded border">
                    <form action="{{ route('pk.berita.images.destroy', [$berita, $image]) }}" method="POST"
                          onsubmit="return confirm('Hapus gambar ini?')" class="absolute top-0 right-0">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white text-xs px-1 rounded-bl">x</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada gambar.</p>
            @endforelse
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Tambah Gambar Baru (opsional)</label>
        <input type="file" name="images[]" multiple accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="w-full border rounded px-3 py-2">
        <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WEBP. Maksimal 10 MB per gambar.</p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="draft" @selected(old('status', $berita->status) === 'draft')>Draft</option>
            <option value="review" @selected(old('status', $berita->status) === 'review')>Review</option>
            <option value="published" @selected(old('status', $berita->status) === 'published')>Published</option>
        </select>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Update</button>
    <a href="{{ route('pk.berita.index') }}" class="text-sm underline ml-2">Batal</a>
</form>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', { theme: 'snow' });
    const contentField = document.getElementById('content');

    if (contentField.value) {
        quill.root.innerHTML = contentField.value;
    }

    document.getElementById('content-form').addEventListener('submit', function () {
        contentField.value = quill.root.innerHTML;
    });
</script>
@endsection
