@extends('layouts.app')
@section('title', 'Berita Baru')

@section('content')
<h1 class="text-2xl font-bold mb-6">Berita Baru</h1>

<form id="content-form" action="{{ route('pk.berita.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded shadow max-w-2xl space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="category_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Ringkasan (excerpt)</label>
        <textarea name="excerpt" rows="2" class="w-full border rounded px-3 py-2">{{ old('excerpt') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Isi Berita</label>
        <div id="editor" style="height: 250px;" class="bg-white"></div>
        <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Penulis (bisa pilih lebih dari satu)</label>
        <select name="penulis[]" multiple class="w-full border rounded px-3 py-2 h-32">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->division?->name }})</option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Tahan Ctrl/Cmd untuk memilih lebih dari satu.</p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Upload Gambar (bisa banyak)</label>
        <input type="file" name="images[]" multiple accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="w-full border rounded px-3 py-2">
        <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WEBP. Maksimal 10 MB per gambar.</p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
            <option value="review" @selected(old('status') === 'review')>Review</option>
            <option value="published" @selected(old('status') === 'published')>Published</option>
        </select>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('pk.berita.index') }}" class="text-sm underline ml-2">Batal</a>
</form>

{{-- Quill rich text editor, tanpa perlu API key --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', { theme: 'snow' });
    const contentField = document.getElementById('content');

    // isi ulang editor kalau ada old('content') (misal setelah validasi gagal)
    if (contentField.value) {
        quill.root.innerHTML = contentField.value;
    }

    document.getElementById('content-form').addEventListener('submit', function () {
        contentField.value = quill.root.innerHTML;
    });
</script>
@endsection
