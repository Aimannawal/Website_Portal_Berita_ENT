@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Kategori</h1>

<form action="{{ route('pk.categories.update', $category) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Nama Kategori</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Tipe</label>
        <select name="type" class="w-full border rounded px-3 py-2">
            <option value="berita" @selected(old('type', $category->type) === 'berita')>Berita</option>
            <option value="artikel" @selected(old('type', $category->type) === 'artikel')>Artikel</option>
            <option value="umum" @selected(old('type', $category->type) === 'umum')>Umum</option>
        </select>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Update</button>
    <a href="{{ route('pk.categories.index') }}" class="text-sm underline ml-2">Batal</a>
</form>
@endsection
