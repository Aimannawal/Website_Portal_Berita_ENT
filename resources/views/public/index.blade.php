@extends('layouts.public')

@section('title', 'Beranda — Portal Berita WM')

@section('content')

{{-- =========================================================
    HERO
========================================================= --}}
<section class="relative overflow-hidden rounded-3xl bg-cyan-600 text-white mb-6">

    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">

        <div class="absolute -top-32 -right-20
                    w-96 h-96 rounded-full
                    border-[45px] border-white/10">
        </div>

        <div class="absolute -bottom-40 -left-24
                    w-[28rem] h-[28rem] rounded-full
                    border-[50px] border-yellow-300/10">
        </div>

        <div class="absolute top-16 right-[35%]
                    w-2 h-2 rounded-full bg-yellow-300">
        </div>

        <div class="absolute top-32 right-[25%]
                    w-1.5 h-1.5 rounded-full bg-white/60">
        </div>

    </div>


    <div class="relative px-6 py-12 md:px-10 md:py-16">

        <div class="max-w-3xl">

            {{-- Label --}}
            <div class="inline-flex items-center gap-2
                        px-3 py-1.5 mb-5
                        rounded-full
                        bg-white/10
                        border border-white/20
                        backdrop-blur-sm">

                <span class="relative flex w-2.5 h-2.5">

                    <span class="absolute inline-flex
                                 w-full h-full
                                 rounded-full
                                 bg-yellow-300
                                 opacity-75
                                 animate-ping">
                    </span>

                    <span class="relative inline-flex
                                 w-2.5 h-2.5
                                 rounded-full
                                 bg-yellow-300">
                    </span>

                </span>

                <span class="text-xs font-bold uppercase tracking-wider">
                    Portal Jurnalistik Digital
                </span>

            </div>


            {{-- Heading --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl
                       font-black tracking-tight
                       leading-[1.05]">

                Berita terkini.
                <br>

                <span class="text-yellow-300">
                    Perspektif terpercaya.
                </span>

            </h1>


            <p class="mt-5 max-w-2xl
                      text-sm md:text-base
                      text-cyan-50
                      leading-relaxed">

                Temukan berita terbaru, informasi aktual,
                dan artikel pilihan dari berbagai bidang
                dalam satu portal informasi digital.

            </p>


            {{-- CTA --}}
            <div class="flex flex-wrap gap-3 mt-7">

                <a href="#berita"
                   class="inline-flex items-center gap-2
                          px-5 py-2.5 rounded-xl
                          bg-white text-cyan-700
                          text-sm font-bold
                          hover:bg-yellow-300
                          hover:text-gray-900
                          transition">

                    <i class="fa-solid fa-newspaper"></i>

                    Jelajahi Berita

                </a>


                <a href="#artikel"
                   class="inline-flex items-center gap-2
                          px-5 py-2.5 rounded-xl
                          bg-cyan-500/50
                          border border-white/20
                          text-white
                          text-sm font-semibold
                          hover:bg-white/10
                          transition">

                    <i class="fa-solid fa-file-lines"></i>

                    Baca Artikel

                </a>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    BREAKING NEWS
========================================================= --}}
@if ($berita->count() > 0)

<section class="mb-8 overflow-hidden rounded-xl
                border border-yellow-200
                bg-white">

    <div class="flex items-stretch">

        {{-- Label --}}
        <div class="shrink-0 flex items-center gap-2
                    px-4 py-3
                    bg-yellow-400
                    text-gray-900
                    font-black text-xs
                    uppercase tracking-wider">

            <i class="fa-solid fa-bolt"></i>

            Breaking News

        </div>


        {{-- Ticker --}}
        <div class="relative flex-1 overflow-hidden">

            <div id="breakingTicker"
                 class="flex items-center
                        whitespace-nowrap
                        h-full
                        animate-marquee">

                @foreach ($berita as $item)

                    <a href="{{ route('public.berita.show', $item->slug) }}"
                       class="inline-flex items-center gap-3
                              px-6
                              text-sm font-semibold
                              text-gray-700
                              hover:text-cyan-600">

                        <span class="w-1.5 h-1.5
                                     rounded-full
                                     bg-cyan-500">
                        </span>

                        {{ $item->title }}

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>

@endif



{{-- =========================================================
    FEATURED NEWS
========================================================= --}}
@if ($berita->count() > 0)

<section class="mb-12">

    <div class="flex items-end justify-between mb-5">

        <div>

            <p class="text-xs font-bold uppercase
                      tracking-[0.2em] text-cyan-600">

                Headline

            </p>

            <h2 class="text-2xl md:text-3xl
                       font-black text-gray-900 mt-1">

                Berita Utama

            </h2>

        </div>


        <span class="hidden sm:block
                     text-xs font-bold uppercase
                     tracking-wider text-gray-400">

            Featured Stories

        </span>

    </div>



    <div class="grid lg:grid-cols-5 gap-5">

        {{-- Main News --}}
        @php
            $featured = $berita->first();
        @endphp

        <a href="{{ route('public.berita.show', $featured->slug) }}"
           class="lg:col-span-3 group relative
                  min-h-[360px]
                  rounded-2xl
                  overflow-hidden
                  bg-cyan-700
                  shadow-lg">

            {{-- Background --}}
            <div class="absolute inset-0
                        bg-gradient-to-br
                        from-cyan-500
                        via-cyan-600
                        to-cyan-800">
            </div>


            {{-- Decorative --}}
            <div class="absolute -right-20 -top-20
                        w-72 h-72 rounded-full
                        border-[40px]
                        border-white/10">
            </div>

            <div class="absolute -left-16 -bottom-24
                        w-72 h-72 rounded-full
                        border-[35px]
                        border-yellow-300/10">
            </div>


            {{-- Icon --}}
            <div class="absolute top-8 right-8
                        text-white/10">

                <i class="fa-solid fa-newspaper text-8xl"></i>

            </div>


            {{-- Content --}}
            <div class="absolute inset-x-0 bottom-0
                        p-6 md:p-8
                        bg-gradient-to-t
                        from-gray-950/80
                        via-gray-950/40
                        to-transparent">

                <div class="flex items-center gap-2 mb-3">

                    <span class="px-3 py-1.5
                                 rounded-lg
                                 bg-yellow-400
                                 text-gray-900
                                 text-xs
                                 font-black">

                        {{ $featured->category?->name ?? 'Umum' }}

                    </span>

                    <span class="text-xs
                                 text-white/70
                                 font-semibold">

                        BERITA UTAMA

                    </span>

                </div>


                <h3 class="max-w-2xl
                           text-2xl md:text-3xl
                           font-black
                           text-white
                           leading-tight
                           group-hover:text-yellow-300
                           transition">

                    {{ $featured->title }}

                </h3>


                <p class="max-w-2xl
                          mt-3
                          text-sm
                          text-white/75
                          leading-relaxed">

                    {{ \Illuminate\Support\Str::limit($featured->excerpt, 150) }}

                </p>


                <div class="flex items-center gap-2
                            mt-5
                            text-sm
                            font-bold
                            text-white">

                    Baca selengkapnya

                    <i class="fa-solid fa-arrow-right
                              group-hover:translate-x-1
                              transition-transform">
                    </i>

                </div>

            </div>

        </a>



        {{-- Side Stories --}}
        <div class="lg:col-span-2 grid gap-5">

            @foreach ($berita->skip(1)->take(2) as $item)

                <a href="{{ route('public.berita.show', $item->slug) }}"
                   class="group relative
                          min-h-[170px]
                          rounded-2xl
                          overflow-hidden
                          bg-white
                          border border-gray-200
                          hover:border-cyan-300
                          hover:shadow-lg
                          transition">

                    {{-- Thumbnail --}}
                    <div class="absolute inset-0
                                bg-gradient-to-br
                                from-cyan-50
                                to-cyan-100">

                        <div class="absolute
                                    right-5 top-5
                                    text-cyan-600/10">

                            <i class="fa-solid fa-newspaper
                                      text-7xl">
                            </i>

                        </div>

                    </div>


                    <div class="relative
                                h-full
                                flex flex-col
                                justify-end
                                p-5
                                bg-gradient-to-t
                                from-white
                                via-white/90
                                to-transparent">

                        <div class="mb-2">

                            <span class="px-2.5 py-1
                                         rounded-md
                                         bg-cyan-600
                                         text-white
                                         text-[10px]
                                         font-black">

                                {{ $item->category?->name ?? 'Umum' }}

                            </span>

                        </div>


                        <h3 class="font-extrabold
                                   text-gray-900
                                   leading-snug
                                   group-hover:text-cyan-600
                                   transition">

                            {{ $item->title }}

                        </h3>


                        <div class="flex items-center
                                    gap-2 mt-3
                                    text-xs
                                    font-bold
                                    text-gray-400">

                            Baca berita

                            <i class="fa-solid fa-arrow-right
                                      group-hover:translate-x-1
                                      transition-transform">
                            </i>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</section>

@endif



{{-- =========================================================
    CATEGORY
========================================================= --}}
<section class="mb-12">

    <div class="flex items-end
                justify-between mb-5">

        <div>

            <p class="text-xs font-bold uppercase
                      tracking-[0.2em] text-cyan-600">

                Explore

            </p>

            <h2 class="text-2xl font-black
                       text-gray-900 mt-1">

                Kategori

            </h2>

        </div>

        <span class="hidden md:block
                     text-xs text-gray-400">

            Jelajahi berita berdasarkan topik

        </span>

    </div>


    <div class="flex gap-2 overflow-x-auto
                pb-2 scrollbar-hide">

        {{-- Semua --}}
        <a href="{{ route('public.index') }}"
           class="shrink-0
                  inline-flex items-center gap-2
                  px-4 py-2.5
                  rounded-xl
                  text-sm font-bold
                  transition-all

           @if (!$categorySlug)
               bg-cyan-600 text-white
               shadow-md shadow-cyan-600/20
           @else
               bg-white text-gray-600
               border border-gray-200
               hover:border-cyan-300
               hover:text-cyan-600
           @endif">

            <i class="fa-solid fa-layer-group text-xs"></i>

            Semua

        </a>


        @foreach ($categories as $category)

            <a href="{{ route('public.index', ['kategori' => $category->slug]) }}"
               class="shrink-0
                      px-4 py-2.5
                      rounded-xl
                      text-sm font-semibold
                      transition-all

               @if ($categorySlug == $category->slug)
                   bg-cyan-600 text-white
                   shadow-md shadow-cyan-600/20
               @else
                   bg-white text-gray-600
                   border border-gray-200
                   hover:border-cyan-300
                   hover:text-cyan-600
               @endif">

                {{ $category->name }}

            </a>

        @endforeach

    </div>

</section>



{{-- =========================================================
    QUICK INFO
========================================================= --}}
<section class="grid grid-cols-1
                sm:grid-cols-3
                gap-4 mb-12">

    {{-- Berita --}}
    <div class="group
                bg-white
                border border-gray-200
                rounded-2xl
                p-5
                hover:border-cyan-300
                hover:shadow-md
                transition">

        <div class="flex items-center
                    justify-between">

            <div>

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-gray-400">

                    Berita

                </p>

                <p class="text-3xl
                          font-black
                          text-gray-900
                          mt-1">

                    {{ $berita->total() }}

                </p>

            </div>


            <div class="w-11 h-11
                        rounded-xl
                        flex items-center
                        justify-center
                        bg-cyan-50
                        text-cyan-600
                        group-hover:bg-cyan-600
                        group-hover:text-white
                        transition">

                <i class="fa-solid fa-newspaper"></i>

            </div>

        </div>

        <p class="text-xs
                  text-gray-400 mt-3">

            Informasi berita tersedia

        </p>

    </div>


    {{-- Artikel --}}
    <div class="group
                bg-white
                border border-gray-200
                rounded-2xl
                p-5
                hover:border-cyan-300
                hover:shadow-md
                transition">

        <div class="flex items-center
                    justify-between">

            <div>

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-gray-400">

                    Artikel

                </p>

                <p class="text-3xl
                          font-black
                          text-gray-900
                          mt-1">

                    {{ $artikel->total() }}

                </p>

            </div>


            <div class="w-11 h-11
                        rounded-xl
                        flex items-center
                        justify-center
                        bg-yellow-50
                        text-yellow-600
                        group-hover:bg-yellow-400
                        group-hover:text-gray-900
                        transition">

                <i class="fa-solid fa-file-lines"></i>

            </div>

        </div>

        <p class="text-xs
                  text-gray-400 mt-3">

            Wawasan dan informasi pilihan

        </p>

    </div>


    {{-- Kategori --}}
    <div class="group
                bg-white
                border border-gray-200
                rounded-2xl
                p-5
                hover:border-cyan-300
                hover:shadow-md
                transition">

        <div class="flex items-center
                    justify-between">

            <div>

                <p class="text-xs
                          font-bold
                          uppercase
                          tracking-wider
                          text-gray-400">

                    Kategori

                </p>

                <p class="text-3xl
                          font-black
                          text-gray-900
                          mt-1">

                    {{ $categories->count() }}

                </p>

            </div>


            <div class="w-11 h-11
                        rounded-xl
                        flex items-center
                        justify-center
                        bg-cyan-50
                        text-cyan-600
                        group-hover:bg-cyan-600
                        group-hover:text-white
                        transition">

                <i class="fa-solid fa-tags"></i>

            </div>

        </div>

        <p class="text-xs
                  text-gray-400 mt-3">

            Topik yang tersedia

        </p>

    </div>

</section>



{{-- =========================================================
    BERITA TERBARU
========================================================= --}}
<section id="berita" class="mb-14">

    <div class="flex items-end
                justify-between mb-6">

        <div>

            <div class="flex items-center gap-3">

                <span class="w-1.5 h-8
                             rounded-full
                             bg-yellow-400">
                </span>

                <h2 class="text-2xl md:text-3xl
                           font-black
                           text-gray-900">

                    Berita Terbaru

                </h2>

            </div>

            <p class="text-sm text-gray-500 mt-2 ml-4">

                Informasi terbaru dan aktual

            </p>

        </div>


        <span class="hidden sm:block
                     text-xs font-bold
                     uppercase
                     tracking-wider
                     text-cyan-600">

            Latest News

        </span>

    </div>


    <div class="grid sm:grid-cols-2
                lg:grid-cols-3
                gap-5">

        @forelse ($berita as $item)

            <article
                class="news-card group
                       bg-white
                       rounded-2xl
                       border border-gray-200
                       overflow-hidden
                       hover:border-cyan-300
                       hover:shadow-xl
                       hover:shadow-cyan-900/5
                       hover:-translate-y-1
                       transition-all duration-300">


                {{-- Thumbnail --}}
                <a href="{{ route('public.berita.show', $item->slug) }}">

                    <div class="relative h-48
                                overflow-hidden
                                bg-gradient-to-br
                                from-cyan-500
                                to-cyan-700">

                        <div class="absolute inset-0">

                            <div class="absolute
                                        -right-10 -top-10
                                        w-48 h-48
                                        rounded-full
                                        border-[25px]
                                        border-white/10">
                            </div>

                            <div class="absolute
                                        -left-16 -bottom-20
                                        w-56 h-56
                                        rounded-full
                                        border-[30px]
                                        border-yellow-300/10">
                            </div>

                        </div>


                        <div class="absolute inset-0
                                    flex items-center
                                    justify-center">

                            <div class="text-center">

                                <i class="fa-solid fa-newspaper
                                          text-4xl
                                          text-white/80
                                          mb-3">
                                </i>

                                <div class="text-[9px]
                                            uppercase
                                            tracking-[0.4em]
                                            text-cyan-100">

                                    Digital Journalism

                                </div>

                            </div>

                        </div>


                        <div class="absolute top-4 left-4">

                            <span class="inline-flex
                                         px-3 py-1.5
                                         rounded-lg
                                         bg-white/90
                                         text-cyan-700
                                         text-xs
                                         font-black">

                                {{ $item->category?->name ?? 'Umum' }}

                            </span>

                        </div>

                    </div>

                </a>



                {{-- Content --}}
                <div class="p-5">

                    <div class="flex items-center
                                gap-2 mb-3
                                text-[10px]
                                font-bold
                                tracking-wider
                                text-gray-400">

                        <span>BERITA</span>

                        <span class="w-1 h-1
                                     rounded-full
                                     bg-gray-300">
                        </span>

                        <span>TERBARU</span>

                    </div>


                    <a href="{{ route('public.berita.show', $item->slug) }}">

                        <h3 class="text-lg
                                   font-extrabold
                                   text-gray-900
                                   leading-snug
                                   group-hover:text-cyan-600
                                   transition-colors">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <p class="text-sm
                              text-gray-500
                              leading-relaxed
                              mt-3">

                        {{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}

                    </p>


                    <div class="flex items-center
                                justify-between
                                mt-5 pt-4
                                border-t
                                border-gray-100">

                        <span class="text-xs
                                     text-gray-400">

                            Baca selengkapnya

                        </span>


                        <span class="flex items-center
                                     justify-center
                                     w-8 h-8
                                     rounded-lg
                                     bg-cyan-50
                                     text-cyan-600
                                     group-hover:bg-cyan-600
                                     group-hover:text-white
                                     transition">

                            <i class="fa-solid fa-arrow-right"></i>

                        </span>

                    </div>

                </div>

            </article>

        @empty

            <div class="col-span-full
                        py-16
                        text-center
                        bg-white
                        border border-dashed
                        border-gray-300
                        rounded-2xl">

                <i class="fa-regular fa-newspaper
                          text-4xl
                          text-gray-200
                          mb-4">
                </i>

                <p class="font-bold text-gray-600">

                    Belum ada berita.

                </p>

                <p class="text-sm text-gray-400 mt-1">

                    Berita terbaru akan muncul di sini.

                </p>

            </div>

        @endforelse

    </div>


    @if ($berita->hasPages())

        <div class="mt-7">

            {{ $berita->links() }}

        </div>

    @endif

</section>



{{-- =========================================================
    ARTIKEL TERBARU
========================================================= --}}
<section id="artikel" class="mb-14">

    <div class="flex items-end
                justify-between mb-6">

        <div>

            <div class="flex items-center gap-3">

                <span class="w-1.5 h-8
                             rounded-full
                             bg-cyan-500">
                </span>

                <h2 class="text-2xl md:text-3xl
                           font-black
                           text-gray-900">

                    Artikel Terbaru

                </h2>

            </div>


            <p class="text-sm
                      text-gray-500
                      mt-2 ml-4">

                Wawasan dan informasi pilihan

            </p>

        </div>


        <span class="hidden sm:block
                     text-xs font-bold
                     uppercase
                     tracking-wider
                     text-cyan-600">

            Featured Articles

        </span>

    </div>



    <div class="grid sm:grid-cols-2
                lg:grid-cols-3
                gap-5">

        @forelse ($artikel as $item)

            <article
                class="article-card group
                       bg-white
                       rounded-2xl
                       border border-gray-200
                       p-5
                       hover:border-cyan-300
                       hover:shadow-xl
                       hover:shadow-cyan-900/5
                       hover:-translate-y-1
                       transition-all duration-300">

                <div class="flex items-center
                            justify-between mb-5">

                    <span class="inline-flex
                                 items-center
                                 px-3 py-1.5
                                 rounded-lg
                                 bg-yellow-50
                                 text-yellow-700
                                 text-xs
                                 font-black">

                        {{ $item->category?->name ?? 'Umum' }}

                    </span>


                    <span class="text-[10px]
                                 font-bold
                                 text-gray-400
                                 uppercase
                                 tracking-wider">

                        Artikel

                    </span>

                </div>


                <a href="{{ route('public.artikel.show', $item->slug) }}">

                    <h3 class="text-xl
                               font-extrabold
                               text-gray-900
                               leading-snug
                               group-hover:text-cyan-600
                               transition-colors">

                        {{ $item->title }}

                    </h3>

                </a>


                <p class="text-sm
                          text-gray-500
                          leading-relaxed
                          mt-3">

                    {{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}

                </p>


                <a href="{{ route('public.artikel.show', $item->slug) }}"
                   class="inline-flex
                          items-center
                          gap-2
                          mt-6
                          text-sm
                          font-bold
                          text-cyan-600">

                    Baca artikel

                    <i class="fa-solid fa-arrow-right
                              text-xs
                              group-hover:translate-x-1
                              transition-transform">
                    </i>

                </a>

            </article>

        @empty

            <div class="col-span-full
                        py-16
                        text-center
                        bg-white
                        border border-dashed
                        border-gray-300
                        rounded-2xl">

                <i class="fa-regular fa-file-lines
                          text-4xl
                          text-gray-200
                          mb-4">
                </i>

                <p class="font-bold text-gray-600">

                    Belum ada artikel.

                </p>

                <p class="text-sm
                          text-gray-400
                          mt-1">

                    Artikel terbaru akan muncul di sini.

                </p>

            </div>

        @endforelse

    </div>


    @if ($artikel->hasPages())

        <div class="mt-7">

            {{ $artikel->links() }}

        </div>

    @endif

</section>



{{-- =========================================================
    TRENDING TOPICS
========================================================= --}}
<section class="mb-10">

    <div class="rounded-2xl
                bg-gray-950
                overflow-hidden
                relative">

        {{-- Decoration --}}
        <div class="absolute
                    -right-20 -top-24
                    w-72 h-72
                    rounded-full
                    border-[35px]
                    border-cyan-500/10">
        </div>


        <div class="relative p-6 md:p-8">

            <div class="flex items-center
                        gap-3 mb-6">

                <div class="w-10 h-10
                            rounded-xl
                            bg-cyan-500
                            text-white
                            flex items-center
                            justify-center">

                    <i class="fa-solid fa-fire"></i>

                </div>


                <div>

                    <p class="text-xs
                              font-bold
                              uppercase
                              tracking-wider
                              text-cyan-400">

                        Explore More

                    </p>

                    <h2 class="text-xl
                               font-black
                               text-white">

                        Topik Pilihan

                    </h2>

                </div>

            </div>


            <div class="grid sm:grid-cols-2
                        lg:grid-cols-4
                        gap-3">

                @foreach ($categories->take(4) as $index => $category)

                    <a href="{{ route('public.index', ['kategori' => $category->slug]) }}"
                       class="group flex items-center
                              gap-4 p-4
                              rounded-xl
                              bg-white/5
                              border border-white/10
                              hover:bg-cyan-500
                              hover:border-cyan-400
                              transition">

                        <span class="text-2xl
                                     font-black
                                     text-white/20
                                     group-hover:text-white/50">

                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                        </span>


                        <span class="flex-1">

                            <span class="block
                                         text-sm
                                         font-bold
                                         text-white">

                                {{ $category->name }}

                            </span>

                            <span class="block
                                         text-[11px]
                                         text-gray-500
                                         group-hover:text-cyan-100
                                         mt-1">

                                Jelajahi topik

                            </span>

                        </span>


                        <i class="fa-solid fa-arrow-right
                                  text-xs
                                  text-cyan-400
                                  group-hover:text-white
                                  group-hover:translate-x-1
                                  transition">
                        </i>

                    </a>

                @endforeach

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SCROLL REVEAL
    |--------------------------------------------------------------------------
    */

    const cards = document.querySelectorAll(
        '.news-card, .article-card'
    );


    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.remove(
                            'opacity-0',
                            'translate-y-5'
                        );

                        entry.target.classList.add(
                            'opacity-100',
                            'translate-y-0'
                        );

                        observer.unobserve(
                            entry.target
                        );

                    }

                });

            },
            {
                threshold: 0.08
            }
        );


        cards.forEach(function (card) {

            card.classList.add(
                'opacity-0',
                'translate-y-5',
                'transition-all',
                'duration-500'
            );

            observer.observe(card);

        });

    }



    /*
    |--------------------------------------------------------------------------
    | SMOOTH SCROLL
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'a[href^="#"]'
    ).forEach(function (link) {

        link.addEventListener('click', function (event) {

            const targetId =
                this.getAttribute('href');

            const target =
                document.querySelector(targetId);


            if (!target) {
                return;
            }


            event.preventDefault();


            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        });

    });



    /*
    |--------------------------------------------------------------------------
    | NAVBAR SCROLL EFFECT
    |--------------------------------------------------------------------------
    */

    const navbar =
        document.querySelector('nav');


    if (navbar) {

        window.addEventListener(
            'scroll',
            function () {

                if (window.scrollY > 20) {

                    navbar.classList.add(
                        'shadow-md'
                    );

                } else {

                    navbar.classList.remove(
                        'shadow-md'
                    );

                }

            }
        );

    }



    /*
    |--------------------------------------------------------------------------
    | PAUSE BREAKING NEWS ON HOVER
    |--------------------------------------------------------------------------
    */

    const ticker =
        document.getElementById(
            'breakingTicker'
        );


    if (ticker) {

        ticker.addEventListener(
            'mouseenter',
            function () {

                ticker.style.animationPlayState =
                    'paused';

            }
        );


        ticker.addEventListener(
            'mouseleave',
            function () {

                ticker.style.animationPlayState =
                    'running';

            }
        );

    }

});

</script>



{{-- =========================================================
    CUSTOM ANIMATION
========================================================= --}}
<style>

@keyframes marquee {

    0% {
        transform: translateX(100%);
    }

    100% {
        transform: translateX(-100%);
    }

}


.animate-marquee {

    animation: marquee 30s linear infinite;

}


.scrollbar-hide::-webkit-scrollbar {

    display: none;

}


.scrollbar-hide {

    -ms-overflow-style: none;
    scrollbar-width: none;

}

</style>

@endsection
