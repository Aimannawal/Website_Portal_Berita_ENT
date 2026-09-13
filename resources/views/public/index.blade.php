@extends('layouts.public')
@section('title', 'Beranda — Portal Berita WM')

@section('content')
<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('public.index') }}"
       class="px-3 py-1 rounded text-sm {{ !$categorySlug ? 'bg-gray-900 text-white' : 'bg-gray-200' }}">
        Semua
    </a>
    @foreach ($categories as $category)
        <a href="{{ route('public.index', ['kategori' => $category->slug]) }}"
           class="px-3 py-1 rounded text-sm {{ $categorySlug === $category->slug ? 'bg-gray-900 text-white' : 'bg-gray-200' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>

<h2 class="text-xl font-bold mb-4">Berita Terbaru</h2>
<div class="grid md:grid-cols-3 gap-4 mb-4">
    @forelse ($berita as $item)
        <a href="{{ route('public.berita.show', $item->slug) }}" class="block border rounded p-4 hover:shadow">
            <p class="text-xs text-gray-500 mb-1">{{ $item->category?->name ?? 'Umum' }}</p>
            <p class="font-semibold">{{ $item->title }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($item->excerpt, 100) }}</p>
        </a>
    @empty
        <p class="text-sm text-gray-500 col-span-3">Belum ada berita.</p>
    @endforelse
</div>
<div class="mb-10">{{ $berita->links() }}</div>

<h2 class="text-xl font-bold mb-4">Artikel Terbaru</h2>
<div class="grid md:grid-cols-3 gap-4 mb-4">
    @forelse ($artikel as $item)
        <a href="{{ route('public.artikel.show', $item->slug) }}" class="block border rounded p-4 hover:shadow">
            <p class="text-xs text-gray-500 mb-1">{{ $item->category?->name ?? 'Umum' }}</p>
            <p class="font-semibold">{{ $item->title }}</p>
            <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($item->excerpt, 100) }}</p>
        </a>
    @empty
        <p class="text-sm text-gray-500 col-span-3">Belum ada artikel.</p>
    @endforelse
</div>
<div>{{ $artikel->links() }}</div>
@endsection
