@extends('layouts.public')
@section('title', $berita->title . ' — NewsHub')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($berita->excerpt ?: $berita->content), 155))
@section('og_type', 'article')
@section('og_image', $berita->images->isNotEmpty() ? $berita->images->first()->url : ($berita->thumbnail ? asset('storage/' . $berita->thumbnail) : asset('images/placeholder.svg')))

@section('content')
    @include('public.partials.content-detail', [
        'item' => $berita,
        'related' => $related,
        'typeLabel' => 'Berita',
        'showRouteName' => 'public.berita.show',
    ])
@endsection
