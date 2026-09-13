@extends('layouts.public')
@section('title', 'Halaman Tidak Ditemukan — NewsHub')

@section('content')
<div class="mx-auto max-w-xl py-16 text-center">
    <p class="text-8xl font-black tracking-tight text-slate-200">404</p>
    <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-slate-900">Halaman tidak ditemukan</h1>
    <p class="mt-3 text-sm leading-relaxed text-slate-500">
        Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau alamatnya salah ketik.
    </p>

    <form action="{{ route('public.index') }}" method="GET" class="mx-auto mt-8 flex max-w-sm">
        <input type="text" name="q" placeholder="Cari berita atau artikel..."
               class="w-full rounded-l-full border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-slate-500">
        <button type="submit" class="rounded-r-full bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">
            Cari
        </button>
    </form>

    <a href="{{ route('public.index') }}"
       class="mt-8 inline-flex items-center gap-1 text-sm font-semibold text-red-600 transition hover:text-red-700">
        &larr; Kembali ke beranda
    </a>
</div>
@endsection
