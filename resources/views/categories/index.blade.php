@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kategori</h1>
    <a href="{{ route('pk.categories.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah Kategori</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Tipe</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($categories as $category)
                <tr>
                    <td class="p-3">{{ $category->name }}</td>
                    <td class="p-3">{{ $category->type }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('pk.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('pk.categories.destroy', $category) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection
