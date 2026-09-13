@extends('layouts.public')
@section('title', 'Beranda — NewsHub')

@php
    use Illuminate\Support\Str;

    // Helper kecil untuk meta waktu baca & waktu relatif
    $readTime = fn ($item) => max(1, (int) ceil(str_word_count(strip_tags($item->content ?? '')) / 200)) . ' min read';
    $timeAgo = fn ($item) => $item->published_at ? $item->published_at->diffForHumans() : '-';
    $thumb = function ($item) {
        if ($item->images?->isNotEmpty()) {
            return $item->images->first()->url;
        }
        if ($item->thumbnail) {
            return asset('storage/' . $item->thumbnail);
        }
        return asset('images/placeholder.svg');
    };
    $authorName = fn ($item) => $item->penulis->first()?->name ?? $item->creator?->name ?? 'Redaksi';
    $authorInitial = fn ($item) => strtoupper(Str::substr($authorName($item), 0, 1));
@endphp

@section('content')

{{-- ===== Info hasil pencarian ===== --}}
@if ($isSearching)
    <div class="mb-8 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
        <p class="text-sm text-slate-600">
            Hasil pencarian untuk
            <span class="font-bold text-slate-900">&ldquo;{{ $search }}&rdquo;</span>
            — {{ $berita->total() + $artikel->total() }} konten ditemukan
        </p>
        <a href="{{ route('public.index') }}" class="rounded-full bg-slate-900 px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-slate-700">
            Hapus pencarian
        </a>
    </div>
@endif

{{-- ===== Filter Kategori ===== --}}
<div class="mb-8 flex flex-wrap items-center gap-2">
    <a href="{{ route('public.index') }}"
       class="rounded-full px-4 py-1.5 text-xs font-semibold transition {{ !$categorySlug ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
        Semua
    </a>
    @foreach ($categories as $category)
        <a href="{{ route('public.index', ['kategori' => $category->slug]) }}"
           class="rounded-full px-4 py-1.5 text-xs font-semibold transition {{ $categorySlug === $category->slug ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>

{{-- ===== Hero + Featured Sidebar ===== --}}
@if ($heroBerita)
<section class="grid gap-6 lg:grid-cols-5">
    {{-- Hero utama --}}
    <a href="{{ route('public.berita.show', $heroBerita->slug) }}"
       class="group relative block overflow-hidden rounded-2xl lg:col-span-3">
        <img src="{{ $thumb($heroBerita) }}" alt="{{ $heroBerita->title }}"
             class="h-[320px] w-full object-cover transition duration-500 group-hover:scale-105 sm:h-[420px]">
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
            <div class="mb-3 flex items-center gap-2 text-xs font-semibold">
                <span class="rounded bg-red-600 px-2 py-0.5 uppercase tracking-wide text-white">
                    {{ $heroBerita->category?->name ?? 'Umum' }}
                </span>
                <span class="text-slate-300">{{ $timeAgo($heroBerita) }}</span>
            </div>
            <h1 class="max-w-2xl text-2xl font-extrabold leading-tight text-white sm:text-3xl">
                {{ $heroBerita->title }}
            </h1>
            <p class="mt-2 hidden max-w-xl text-sm text-slate-300 sm:block">
                {{ Str::limit($heroBerita->excerpt, 140) }}
            </p>
            <div class="mt-4 flex items-center gap-2 text-xs text-slate-300">
                <span class="grid h-6 w-6 place-items-center rounded-full bg-white/20 text-[10px] font-bold text-white">
                    {{ $authorInitial($heroBerita) }}
                </span>
                <span class="font-semibold text-white">{{ $authorName($heroBerita) }}</span>
                <span>&middot;</span>
                <span>{{ $readTime($heroBerita) }}</span>
            </div>
        </div>
    </a>

    {{-- Sidebar featured --}}
    <div class="flex flex-col gap-4 lg:col-span-2">
        @forelse ($featuredItems as $item)
            <a href="{{ route('public.berita.show', $item->slug) }}"
               class="group flex flex-1 items-stretch gap-4 overflow-hidden rounded-xl border border-slate-100 bg-white p-3 transition hover:shadow-md">
                <img src="{{ $thumb($item) }}" alt="{{ $item->title }}"
                     class="h-full min-h-[72px] w-24 shrink-0 rounded-lg object-cover sm:w-28">
                <div class="flex min-w-0 flex-col justify-center py-1">
                    <div class="mb-1 flex items-center gap-2 text-[11px] font-semibold">
                        <span class="text-red-600">{{ $item->category?->name ?? 'Umum' }}</span>
                        <span class="text-slate-400">&middot; {{ $timeAgo($item) }}</span>
                    </div>
                    <h3 class="line-clamp-2 text-sm font-bold leading-snug text-slate-900 transition group-hover:text-red-600">
                        {{ $item->title }}
                    </h3>
                    <p class="mt-1 text-[11px] text-slate-400">{{ $readTime($item) }}</p>
                </div>
            </a>
        @empty
            <p class="text-sm text-slate-400">Belum ada berita unggulan lainnya.</p>
        @endforelse
    </div>
</section>
@endif

{{-- ===== Latest News + Right Sidebar ===== --}}
<section class="mt-12 grid gap-10 lg:grid-cols-3">
    {{-- Kolom utama: Latest News --}}
    <div class="lg:col-span-2">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-2xl font-extrabold tracking-tight">
                {{ $isSearching ? 'Berita Ditemukan' : 'Berita Terbaru' }}
            </h2>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($berita as $item)
                <a href="{{ route('public.berita.show', $item->slug) }}" class="group">
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ $thumb($item) }}" alt="{{ $item->title }}"
                             class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="mt-3 flex items-center gap-2 text-[11px] font-semibold">
                        <span class="text-red-600">{{ $item->category?->name ?? 'Umum' }}</span>
                        <span class="text-slate-400">&middot; {{ $timeAgo($item) }}</span>
                    </div>
                    <h3 class="mt-1 line-clamp-2 text-[15px] font-bold leading-snug transition group-hover:text-red-600">
                        {{ $item->title }}
                    </h3>
                    <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-slate-500">
                        {{ Str::limit($item->excerpt, 110) }}
                    </p>
                    <p class="mt-2 text-[11px] text-slate-400">{{ $readTime($item) }}</p>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    <p class="mt-3 text-sm font-semibold text-slate-700">Tidak ada berita yang cocok</p>
                    <p class="mt-1 text-xs text-slate-400">Coba kata kunci atau kategori lain.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $berita->links() }}</div>

        {{-- Artikel / Weekly Highlight --}}
        <div class="mb-6 mt-12 flex items-center justify-between">
            <h2 class="text-2xl font-extrabold tracking-tight">
                {{ $isSearching ? 'Artikel Ditemukan' : 'Sorotan Mingguan' }}
            </h2>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @forelse ($artikel as $item)
                <a href="{{ route('public.artikel.show', $item->slug) }}" class="group">
                    <div class="overflow-hidden rounded-xl">
                        <img src="{{ $thumb($item) }}" alt="{{ $item->title }}"
                             class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="mt-3 flex items-center gap-2 text-[11px] font-semibold">
                        <span class="text-red-600">{{ $item->category?->name ?? 'Umum' }}</span>
                        <span class="text-slate-400">&middot; {{ $timeAgo($item) }}</span>
                    </div>
                    <h3 class="mt-1 line-clamp-2 text-[15px] font-bold leading-snug transition group-hover:text-red-600">
                        {{ $item->title }}
                    </h3>
                    <p class="mt-2 text-[11px] text-slate-400">{{ $readTime($item) }}</p>
                </a>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center">
                    <p class="text-sm font-semibold text-slate-700">Tidak ada artikel yang cocok</p>
                    <p class="mt-1 text-xs text-slate-400">Coba kata kunci atau kategori lain.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-8">{{ $artikel->links() }}</div>
    </div>

    {{-- Sidebar kanan --}}
    <aside class="space-y-10">
        {{-- Must Read --}}
        <div>
            <h3 class="mb-4 text-lg font-extrabold tracking-tight">Wajib Dibaca</h3>
            <div class="space-y-4">
                @forelse ($mustRead as $item)
                    <a href="{{ route('public.artikel.show', $item->slug) }}" class="group flex gap-3">
                        <img src="{{ $thumb($item) }}" alt="{{ $item->title }}"
                             class="h-16 w-20 shrink-0 rounded-lg object-cover">
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold text-red-600">{{ $item->category?->name ?? 'Artikel' }}</p>
                            <h4 class="mt-0.5 line-clamp-2 text-sm font-bold leading-snug transition group-hover:text-red-600">
                                {{ $item->title }}
                            </h4>
                            <p class="mt-1 text-[11px] text-slate-400">{{ $timeAgo($item) }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Belum ada artikel pilihan.</p>
                @endforelse
            </div>
        </div>

        {{-- Top Creator --}}
        @if ($creators->isNotEmpty())
        <div>
            <h3 class="mb-4 text-lg font-extrabold tracking-tight">Kreator Teratas</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ($creators as $creator)
                    <div class="flex items-center gap-2">
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-slate-900 text-xs font-bold text-white">
                            {{ strtoupper(Str::substr($creator->name, 0, 1)) }}
                        </span>
                        <div>
                            <p class="text-xs font-bold">{{ $creator->name }}</p>
                            <p class="text-[10px] text-slate-400">{{ $creator->berita_ditulis_count }} berita</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Newsletter box --}}
        <div class="rounded-2xl bg-slate-900 p-6 text-white">
            <h3 class="text-lg font-extrabold">Berlangganan NewsHub</h3>
            <p class="mt-2 text-xs leading-relaxed text-slate-400">
                Dapatkan ringkasan berita dan artikel terbaik setiap pagi langsung di email Anda.
            </p>
            @if (session('newsletter_success'))
                <p class="mt-4 rounded-lg bg-green-500/15 px-3 py-2 text-xs font-medium text-green-300">
                    {{ session('newsletter_success') }}
                </p>
            @else
                <form action="{{ route('public.subscribe') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex">
                        <input type="email" name="email" placeholder="Email Anda" required
                               class="w-full rounded-l-lg border-0 bg-white/10 px-3 py-2 text-sm text-white placeholder-slate-400 outline-none focus:bg-white/20">
                        <button type="submit" class="rounded-r-lg bg-red-600 px-3 py-2 text-sm font-semibold transition hover:bg-red-500">
                            Ikut
                        </button>
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs text-red-300">{{ $message }}</p>
                    @enderror
                </form>
            @endif
        </div>
    </aside>
</section>
@endsection
