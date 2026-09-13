@extends('layouts.public')
@section('title', $artikel->title . ' — NewsHub')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($artikel->excerpt ?: $artikel->content), 155))
@section('og_type', 'article')
@section('og_image', $artikel->images->isNotEmpty() ? $artikel->images->first()->url : ($artikel->thumbnail ? asset('storage/' . $artikel->thumbnail) : asset('images/placeholder.svg')))

@section('content')
    @include('public.partials.content-detail', [
        'item' => $artikel,
        'related' => $related,
        'typeLabel' => 'Artikel',
        'showRouteName' => 'public.artikel.show',
    ])
@endsection
