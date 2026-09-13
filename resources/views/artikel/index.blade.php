@extends('layouts.app')
@section('title', 'Artikel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Artikel</h1>
    <a href="{{ route('pk.artikel.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Artikel Baru</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Judul</th>
                <th class="p-3">Kategori</th>
                <th class="p-3">Dibuat oleh</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($artikel as $item)
                <tr>
                    <td class="p-3">{{ $item->title }}</td>
                    <td class="p-3">{{ $item->category?->name ?? '-' }}</td>
                    <td class="p-3">{{ $item->creator?->name }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            @class([
                                'bg-gray-200 text-gray-700' => $item->status === 'draft',
                                'bg-yellow-100 text-yellow-700' => $item->status === 'review',
                                'bg-green-100 text-green-700' => $item->status === 'published',
                            ])">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('pk.artikel.edit', $item) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('pk.artikel.destroy', $item) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin hapus artikel ini?')">
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

<div class="mt-4">{{ $artikel->links() }}</div>
@endsection
