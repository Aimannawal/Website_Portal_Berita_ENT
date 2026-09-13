@extends('layouts.public')
@section('title', $artikel->title)

@section('content')
<a href="{{ route('public.index') }}" class="text-sm underline">← Kembali</a>

<p class="text-xs text-gray-500 mt-4">{{ $artikel->category?->name ?? 'Umum' }} — {{ $artikel->published_at?->format('d M Y') }}</p>
<h1 class="text-3xl font-bold mt-1 mb-2">{{ $artikel->title }}</h1>
<p class="text-sm text-gray-500 mb-6">
    Oleh: {{ $artikel->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}
</p>

@if ($artikel->images->isNotEmpty())
    <div class="grid md:grid-cols-2 gap-3 mb-6">
        @foreach ($artikel->images as $image)
            <img src="{{ asset('storage/' . $image->file_path) }}" class="rounded w-full object-cover">
        @endforeach
    </div>
@endif

<div class="rich-content max-w-none">
    {!! $artikel->content !!}
</div>
@endsection
