@extends('layouts.public')
@section('title', $berita->title)

@section('content')
<a href="{{ route('public.index') }}" class="text-sm underline">← Kembali</a>

<p class="text-xs text-gray-500 mt-4">{{ $berita->category?->name ?? 'Umum' }} — {{ $berita->published_at?->format('d M Y') }}</p>
<h1 class="text-3xl font-bold mt-1 mb-2">{{ $berita->title }}</h1>
<p class="text-sm text-gray-500 mb-6">
    Oleh: {{ $berita->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}
</p>

@if ($berita->images->isNotEmpty())
    <div class="grid md:grid-cols-2 gap-3 mb-6">
        @foreach ($berita->images as $image)
            <img src="{{ asset('storage/' . $image->file_path) }}" class="rounded w-full object-cover">
        @endforeach
    </div>
@endif

<div class="rich-content max-w-none">
    {!! $berita->content !!}
</div>
@endsection
