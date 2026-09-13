@extends('layouts.public')
@section('title', 'Beranda — Portal Berita WM')

@section('content')

{{-- =========================================================
    HERO
========================================================= --}}
<section class="relative overflow-hidden rounded-3xl bg-cyan-600 text-white mb-8">

    {{-- Decorative Elements --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">

        <div class="absolute -top-32 -right-24
                    w-96 h-96 rounded-full
                    border-[45px] border-white/10">
        </div>

        <div class="absolute -bottom-40 -left-24
                    w-[28rem] h-[28rem] rounded-full
                    border-[50px] border-yellow-300/10">
        </div>

        <div class="absolute top-20 right-1/3
                    w-2 h-2 rounded-full bg-yellow-300">
        </div>

        <div class="absolute top-1/2 right-1/4
                    w-1.5 h-1.5 rounded-full bg-white/60">
        </div>

    </div>


    <div class="relative px-6 py-10
                md:px-10 md:py-14">

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
                                 w-full h-full rounded-full
                                 bg-yellow-300 opacity-75
                                 animate-ping">
                    </span>

                    <span class="relative inline-flex
                                 w-2.5 h-2.5 rounded-full
                                 bg-yellow-300">
                    </span>

                </span>

                <span class="text-xs font-bold
                             uppercase tracking-wider">
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


            {{-- Description --}}
            <p class="mt-5 max-w-2xl
                      text-sm md:text-base
                      text-cyan-50
                      leading-relaxed">

                Temukan berita terbaru, informasi aktual,
                dan artikel pilihan dari berbagai bidang
                dalam satu portal.

            </p>


            {{-- Buttons --}}
            <div class="flex flex-wrap gap-3 mt-7">

                <a href="#berita"
                   class="inline-flex items-center gap-2
                          px-5 py-2.5
                          rounded-xl
                          bg-white text-cyan-700
                          text-sm font-bold
                          hover:bg-yellow-300
                          hover:text-gray-900
                          transition-all duration-200">

                    <i class="fa-solid fa-newspaper"></i>

                    Jelajahi Berita

                </a>


                <button type="button"
                        id="heroSearchButton"
                        class="inline-flex items-center gap-2
                               px-5 py-2.5
                               rounded-xl
                               bg-cyan-500/50
                               border border-white/20
                               text-white
                               text-sm font-semibold
                               hover:bg-white/10
                               transition">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    Cari Berita

                </button>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    SEARCH MODAL
========================================================= --}}
<div id="searchOverlay"
     class="fixed inset-0 z-50 hidden">

    {{-- Backdrop --}}
    <div id="searchBackdrop"
         class="absolute inset-0
                bg-gray-950/60
                backdrop-blur-sm">
    </div>


    {{-- Modal --}}
    <div class="relative flex justify-center
                min-h-full
                px-4 pt-24">

        <div id="searchBox"
             class="w-full max-w-xl
                    bg-white rounded-2xl
                    shadow-2xl
                    border border-gray-200
                    overflow-hidden
                    opacity-0
                    -translate-y-4
                    transition-all duration-200">

            {{-- Search Input --}}
            <div class="flex items-center gap-3
                        p-4 border-b">

                <i class="fa-solid fa-magnifying-glass
                          text-cyan-600">
                </i>


                <input type="text"
                       id="searchInput"
                       placeholder="Cari berita atau artikel..."
                       class="flex-1
                              bg-transparent
                              outline-none
                              text-sm
                              text-gray-900">


                <button type="button"
                        id="closeSearch"
                        class="w-8 h-8
                               rounded-lg
                               text-gray-400
                               hover:bg-gray-100
                               hover:text-gray-700
                               transition">

                    <i class="fa-solid fa-xmark"></i>

                </button>

            </div>


            {{-- Search Information --}}
            <div class="p-5">

                <div class="flex items-center
                            justify-between mb-3">

                    <p class="text-xs font-bold
                              uppercase
                              tracking-wider
                              text-gray-400">

                        Pencarian

                    </p>

                    <span class="text-[10px]
                                 text-gray-400">

                        ESC untuk menutup

                    </span>

                </div>


                <p id="searchEmpty"
                   class="text-sm text-gray-500">

                    Ketik kata kunci untuk mencari berita.

                </p>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
    CATEGORY
========================================================= --}}
<section class="mb-10">

    <div class="flex items-end
                justify-between mb-4">

        <div>

            <p class="text-xs font-bold
                      uppercase
                      tracking-[0.2em]
                      text-cyan-600">

                Explore

            </p>

            <h2 class="text-2xl font-black
                       text-gray-900 mt-1">

                Kategori

            </h2>

        </div>


        <span class="hidden md:block
                     text-xs text-gray-400">

            Pilih topik yang ingin kamu baca

        </span>

    </div>


    {{-- Category List --}}
    <div class="flex gap-2
                overflow-x-auto
                pb-2
                scrollbar-hide">

        {{-- All --}}
        <a href="{{ route('public.index') }}"
           class="shrink-0
                  inline-flex items-center gap-2
                  px-4 py-2.5
                  rounded-xl
                  text-sm font-bold
                  transition-all

           {{ !$categorySlug
                ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/20'
                : 'bg-white text-gray-600 border border-gray-200 hover:border-cyan-300 hover:text-cyan-600' }}">

            <i class="fa-solid fa-layer-group text-xs"></i>

            Semua

        </a>


        @foreach ($categories as $category)

            <a href="{{ route('public.index', ['kategori' => $category->slug]) }}"
               class="shrink-0
                      inline-flex items-center
                      px-4 py-2.5
                      rounded-xl
                      text-sm font-semibold
                      transition-all

               {{ $categorySlug === $category->slug
                    ? 'bg-cyan-600 text-white shadow-md shadow-cyan-600/20'
                    : 'bg-white text-gray-600 border border-gray-200 hover:border-cyan-300 hover:text-cyan-600' }}">

                {{ $category->name }}

            </a>

        @endforeach

    </div>

</section>



{{-- =========================================================
    BERITA TERBARU
========================================================= --}}
<section id="berita" class="mb-14">

    {{-- Section Header --}}
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


        <div class="hidden sm:flex
                    items-center gap-2
                    text-xs font-bold
                    uppercase
                    tracking-wider
                    text-cyan-600">

            <span class="w-2 h-2
                         rounded-full
                         bg-cyan-500">
            </span>

            Latest News

        </div>

    </div>



    {{-- News Grid --}}
    <div class="grid sm:grid-cols-2
                lg:grid-cols-3 gap-5">

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

                        {{-- Decorative --}}
                        <div class="absolute inset-0
                                    pointer-events-none">

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


                        {{-- News Icon --}}
                        <div class="absolute inset-0
                                    flex items-center
                                    justify-center">

                            <div class="text-center">

                                <i class="fa-solid fa-newspaper
                                          text-4xl
                                          text-white/80 mb-2">
                                </i>

                                <div class="text-[9px]
                                            uppercase
                                            tracking-[0.4em]
                                            text-cyan-100">

                                    Digital Journalism

                                </div>

                            </div>

                        </div>


                        {{-- Category --}}
                        <div class="absolute
                                    top-4 left-4">

                            <span class="inline-flex
                                         items-center
                                         px-3 py-1.5
                                         rounded-lg
                                         bg-white/90
                                         backdrop-blur
                                         text-cyan-700
                                         text-xs font-black
                                         shadow-sm">

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

                        <h3 class="text-lg font-extrabold
                                   text-gray-900
                                   leading-snug
                                   group-hover:text-cyan-600
                                   transition-colors">

                            {{ $item->title }}

                        </h3>

                    </a>


                    <p class="text-sm
                              text-gray-500
                              leading-relaxed mt-3">

                        {{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}

                    </p>


                    {{-- Footer --}}
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
                                     transition-all">

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
                          text-gray-200 mb-4">
                </i>

                <p class="font-bold text-gray-600">

                    Belum ada berita.

                </p>

                <p class="text-sm
                          text-gray-400 mt-1">

                    Berita terbaru akan muncul di sini.

                </p>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    <div class="mt-7">

        {{ $berita->links() }}

    </div>

</section>



{{-- =========================================================
    ARTIKEL TERBARU
========================================================= --}}
<section id="artikel" class="mb-10">

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
                lg:grid-cols-3 gap-5">

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

                {{-- Meta --}}
                <div class="flex items-center
                            justify-between mb-5">

                    <span class="inline-flex
                                 items-center
                                 px-3 py-1.5
                                 rounded-lg
                                 bg-yellow-50
                                 text-yellow-700
                                 text-xs font-black">

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


                {{-- Title --}}
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


                {{-- Excerpt --}}
                <p class="text-sm
                          text-gray-500
                          leading-relaxed mt-3">

                    {{ \Illuminate\Support\Str::limit($item->excerpt, 110) }}

                </p>


                {{-- CTA --}}
                <a href="{{ route('public.artikel.show', $item->slug) }}"
                   class="inline-flex
                          items-center gap-2
                          mt-6
                          text-sm font-bold
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
                          text-gray-200 mb-4">
                </i>

                <p class="font-bold
                          text-gray-600">

                    Belum ada artikel.

                </p>

                <p class="text-sm
                          text-gray-400 mt-1">

                    Artikel terbaru akan muncul di sini.

                </p>

            </div>

        @endforelse

    </div>


    <div class="mt-7">

        {{ $artikel->links() }}

    </div>

</section>



{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SEARCH MODAL
    |--------------------------------------------------------------------------
    */

    const overlay = document.getElementById('searchOverlay');
    const box = document.getElementById('searchBox');

    const openButton =
        document.getElementById('heroSearchButton');

    const closeButton =
        document.getElementById('closeSearch');

    const backdrop =
        document.getElementById('searchBackdrop');

    const input =
        document.getElementById('searchInput');

    const searchEmpty =
        document.getElementById('searchEmpty');


    function openSearch() {

        if (!overlay || !box) return;

        overlay.classList.remove('hidden');

        requestAnimationFrame(function () {

            box.classList.remove(
                'opacity-0',
                '-translate-y-4'
            );

            box.classList.add(
                'opacity-100',
                'translate-y-0'
            );

        });

        setTimeout(function () {

            input?.focus();

        }, 150);

    }


    function closeSearch() {

        if (!overlay || !box) return;

        box.classList.remove(
            'opacity-100',
            'translate-y-0'
        );

        box.classList.add(
            'opacity-0',
            '-translate-y-4'
        );

        setTimeout(function () {

            overlay.classList.add('hidden');

            if (input) {
                input.value = '';
            }

            if (searchEmpty) {

                searchEmpty.textContent =
                    'Ketik kata kunci untuk mencari berita.';

            }

        }, 200);

    }


    openButton?.addEventListener(
        'click',
        openSearch
    );


    closeButton?.addEventListener(
        'click',
        closeSearch
    );


    backdrop?.addEventListener(
        'click',
        closeSearch
    );


    /*
    |--------------------------------------------------------------------------
    | KEYBOARD SHORTCUT
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        // ESC
        if (event.key === 'Escape') {

            closeSearch();

        }


        // CTRL + K / CMD + K
        if (
            (event.ctrlKey || event.metaKey) &&
            event.key.toLowerCase() === 'k'
        ) {

            event.preventDefault();

            openSearch();

        }

    });


    /*
    |--------------------------------------------------------------------------
    | SIMPLE SEARCH FILTER
    |--------------------------------------------------------------------------
    */

    input?.addEventListener('input', function () {

        const keyword =
            input.value.toLowerCase().trim();

        const cards = document.querySelectorAll(
            '.news-card, .article-card'
        );


        if (!keyword) {

            cards.forEach(function (card) {

                card.classList.remove('hidden');

            });

            if (searchEmpty) {

                searchEmpty.textContent =
                    'Ketik kata kunci untuk mencari berita.';

            }

            return;

        }


        let found = 0;


        cards.forEach(function (card) {

            const title =
                card.querySelector('h3')
                    ?.textContent
                    .toLowerCase() || '';

            const excerpt =
                card.querySelector('p')
                    ?.textContent
                    .toLowerCase() || '';


            if (
                title.includes(keyword) ||
                excerpt.includes(keyword)
            ) {

                card.classList.remove('hidden');

                found++;

            } else {

                card.classList.add('hidden');

            }

        });


        if (searchEmpty) {

            searchEmpty.textContent =
                found > 0
                    ? `${found} hasil ditemukan pada halaman ini.`
                    : 'Tidak ada hasil yang sesuai.';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | SCROLL REVEAL
    |--------------------------------------------------------------------------
    */

    const revealItems =
        document.querySelectorAll(
            '.news-card, .article-card'
        );


    if ('IntersectionObserver' in window) {

        const observer =
            new IntersectionObserver(
                function (entries) {

                    entries.forEach(function (entry) {

                        if (entry.isIntersecting) {

                            entry.target.classList.remove(
                                'opacity-0',
                                'translate-y-4'
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


        revealItems.forEach(function (item) {

            item.classList.add(
                'opacity-0',
                'translate-y-4',
                'transition-all',
                'duration-500'
            );

            observer.observe(item);

        });

    }

});

</script>

@endsection
