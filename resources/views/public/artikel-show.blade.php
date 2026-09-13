```blade
@extends('layouts.public')

@section('title', $artikel->title)

@section('content')

{{-- =========================================================
    BACK BUTTON
========================================================= --}}
<div class="mb-6">

    <a href="{{ route('public.index') }}"
       class="inline-flex items-center gap-2
              text-sm font-semibold
              text-gray-500
              hover:text-cyan-600
              transition">

        <i class="fa-solid fa-arrow-left text-xs"></i>

        Kembali ke Beranda

    </a>

</div>



{{-- =========================================================
    ARTICLE
========================================================= --}}
<article>

    {{-- =====================================================
        CATEGORY + DATE
    ====================================================== --}}
    <div class="flex flex-wrap
                items-center
                gap-2
                mb-5">

        <span class="inline-flex
                     items-center
                     px-3 py-1.5
                     rounded-lg
                     bg-yellow-50
                     text-yellow-700
                     text-xs
                     font-black">

            <i class="fa-solid fa-book-open mr-2 text-[10px]"></i>

            {{ $artikel->category?->name ?? 'Umum' }}

        </span>


        @if ($artikel->published_at)

            <span class="w-1 h-1
                         rounded-full
                         bg-gray-300">
            </span>


            <span class="inline-flex
                         items-center
                         gap-1.5
                         text-xs
                         text-gray-500">

                <i class="fa-regular fa-calendar"></i>

                {{ $artikel->published_at->format('d M Y') }}

            </span>

        @endif


        <span class="w-1 h-1
                     rounded-full
                     bg-gray-300">
        </span>


        <span class="inline-flex
                     items-center
                     gap-1.5
                     text-xs
                     text-gray-500">

            <i class="fa-regular fa-clock"></i>

            Artikel

        </span>

    </div>



    {{-- =====================================================
        TITLE
    ====================================================== --}}
    <h1 class="max-w-5xl
               text-4xl
               md:text-5xl
               lg:text-6xl
               font-black
               tracking-tight
               leading-[1.08]
               text-gray-950">

        {{ $artikel->title }}

    </h1>



    {{-- =====================================================
        AUTHOR
    ====================================================== --}}
    <div class="flex flex-wrap
                items-center
                justify-between
                gap-4
                mt-7
                pb-6
                border-b
                border-gray-200">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11
                        rounded-full
                        bg-yellow-400
                        text-gray-900
                        flex items-center
                        justify-center">

                <i class="fa-solid fa-user-pen"></i>

            </div>


            <div>

                <p class="text-[10px]
                          font-bold
                          uppercase
                          tracking-wider
                          text-gray-400">

                    Ditulis oleh

                </p>


                <p class="text-sm
                          font-bold
                          text-gray-800">

                    {{ $artikel->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}

                </p>

            </div>

        </div>


        <div class="flex items-center
                    gap-2
                    text-xs
                    text-gray-400">

            <i class="fa-regular fa-file-lines"></i>

            Artikel

        </div>

    </div>



    {{-- =====================================================
        IMAGE
    ====================================================== --}}
    @if ($artikel->images->isNotEmpty())

        <div class="mt-8 mb-10">

            @if ($artikel->images->count() == 1)

                @php
                    $image = $artikel->images->first();
                @endphp


                {{-- Single Image --}}
                <div class="relative
                            rounded-2xl
                            overflow-hidden
                            bg-gray-100
                            group">

                    <img
                        src="{{ asset('storage/' . $image->file_path) }}"
                        alt="{{ $artikel->title }}"
                        class="w-full
                               max-h-[650px]
                               object-cover
                               cursor-zoom-in
                               group-hover:scale-[1.01]
                               transition-transform
                               duration-500"
                        onclick="openImageModal(this.src)"
                    >


                    <button type="button"
                            onclick="openImageModal('{{ asset('storage/' . $image->file_path) }}')"
                            class="absolute
                                   right-4
                                   bottom-4
                                   w-10 h-10
                                   rounded-xl
                                   bg-white/90
                                   text-gray-700
                                   shadow
                                   flex items-center
                                   justify-center
                                   opacity-0
                                   group-hover:opacity-100
                                   transition">

                        <i class="fa-solid fa-expand"></i>

                    </button>

                </div>

            @else

                {{-- Multiple Images --}}
                <div class="grid
                            md:grid-cols-2
                            gap-3">

                    @foreach ($artikel->images as $image)

                        <div class="relative
                                    rounded-2xl
                                    overflow-hidden
                                    bg-gray-100
                                    group">

                            <img
                                src="{{ asset('storage/' . $image->file_path) }}"
                                alt="{{ $artikel->title }}"
                                class="w-full
                                       h-72
                                       md:h-80
                                       object-cover
                                       cursor-zoom-in
                                       group-hover:scale-105
                                       transition-transform
                                       duration-500"
                                onclick="openImageModal(this.src)"
                            >


                            <div class="absolute inset-0
                                        flex items-center
                                        justify-center
                                        bg-gray-950/0
                                        group-hover:bg-gray-950/20
                                        transition">

                                <span class="opacity-0
                                             group-hover:opacity-100
                                             w-10 h-10
                                             rounded-full
                                             bg-white/90
                                             text-gray-800
                                             flex items-center
                                             justify-center
                                             transition">

                                    <i class="fa-solid fa-expand"></i>

                                </span>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif


            <p class="flex items-center
                      gap-2
                      mt-3
                      text-xs
                      text-gray-400">

                <i class="fa-regular fa-image"></i>

                Gambar dan dokumentasi terkait artikel

            </p>

        </div>

    @endif



    {{-- =====================================================
        MAIN CONTENT
    ====================================================== --}}
    <div class="grid
                lg:grid-cols-[minmax(0,1fr)_260px]
                gap-10
                items-start">


        {{-- =================================================
            ARTICLE BODY
        ================================================== --}}
        <div>

            {{-- Lead --}}
            @if ($artikel->excerpt)

                <div class="flex items-start
                            gap-4
                            mb-8">

                    <span class="shrink-0
                                 w-1
                                 min-h-[64px]
                                 rounded-full
                                 bg-yellow-400">
                    </span>


                    <p class="text-lg
                              md:text-xl
                              font-semibold
                              text-gray-700
                              leading-relaxed">

                        {{ $artikel->excerpt }}

                    </p>

                </div>

            @endif



            {{-- Content --}}
            <div class="rich-content
                        max-w-none
                        text-gray-800">

                {!! $artikel->content !!}

            </div>


            {{-- Article End --}}
            <div class="flex items-center
                        gap-3
                        mt-10
                        pt-6
                        border-t
                        border-gray-200">

                <span class="w-8 h-1
                             rounded-full
                             bg-cyan-500">
                </span>

                <span class="w-2 h-1
                             rounded-full
                             bg-yellow-400">
                </span>

                <span class="text-xs
                             font-bold
                             uppercase
                             tracking-wider
                             text-gray-400">

                    Akhir Artikel

                </span>

            </div>

        </div>



        {{-- =================================================
            SIDEBAR
        ================================================== --}}
        <aside class="lg:sticky lg:top-24">

            {{-- Information --}}
            <div class="rounded-2xl
                        bg-gray-50
                        border border-gray-200
                        p-5">

                <p class="text-xs
                          font-black
                          uppercase
                          tracking-wider
                          text-gray-400
                          mb-4">

                    Informasi Artikel

                </p>


                <div class="space-y-4">

                    {{-- Category --}}
                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8
                                    shrink-0
                                    rounded-lg
                                    bg-yellow-100
                                    text-yellow-600
                                    flex items-center
                                    justify-center">

                            <i class="fa-solid fa-tag text-xs"></i>

                        </div>


                        <div>

                            <p class="text-[10px]
                                      uppercase
                                      font-bold
                                      tracking-wider
                                      text-gray-400">

                                Kategori

                            </p>


                            <p class="text-sm
                                      font-bold
                                      text-gray-800
                                      mt-0.5">

                                {{ $artikel->category?->name ?? 'Umum' }}

                            </p>

                        </div>

                    </div>


                    {{-- Date --}}
                    @if ($artikel->published_at)

                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        shrink-0
                                        rounded-lg
                                        bg-cyan-100
                                        text-cyan-600
                                        flex items-center
                                        justify-center">

                                <i class="fa-regular fa-calendar text-xs"></i>

                            </div>


                            <div>

                                <p class="text-[10px]
                                          uppercase
                                          font-bold
                                          tracking-wider
                                          text-gray-400">

                                    Dipublikasikan

                                </p>


                                <p class="text-sm
                                          font-bold
                                          text-gray-800
                                          mt-0.5">

                                    {{ $artikel->published_at->format('d M Y') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- Author --}}
                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8
                                    shrink-0
                                    rounded-lg
                                    bg-yellow-100
                                    text-yellow-600
                                    flex items-center
                                    justify-center">

                            <i class="fa-solid fa-pen-nib text-xs"></i>

                        </div>


                        <div>

                            <p class="text-[10px]
                                      uppercase
                                      font-bold
                                      tracking-wider
                                      text-gray-400">

                                Penulis

                            </p>


                            <p class="text-sm
                                      font-bold
                                      text-gray-800
                                      mt-0.5">

                                {{ $artikel->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            {{-- Share --}}
            <div class="mt-4
                        rounded-2xl
                        bg-gray-950
                        p-5
                        text-white">

                <div class="flex items-center
                            gap-2">

                    <i class="fa-solid fa-share-nodes
                              text-yellow-400">
                    </i>

                    <p class="text-xs
                              font-black
                              uppercase
                              tracking-wider">

                        Bagikan Artikel

                    </p>

                </div>


                <p class="text-xs
                          text-gray-400
                          mt-2 mb-4">

                    Bagikan artikel ini kepada orang lain.

                </p>


                <div class="flex gap-2">

                    <button type="button"
                            onclick="shareArticle()"
                            class="flex-1
                                   h-9
                                   rounded-lg
                                   bg-white/10
                                   hover:bg-cyan-500
                                   flex items-center
                                   justify-center
                                   transition">

                        <i class="fa-solid fa-share-nodes text-sm"></i>

                    </button>


                    <button type="button"
                            onclick="copyArticleLink()"
                            class="flex-1
                                   h-9
                                   rounded-lg
                                   bg-white/10
                                   hover:bg-yellow-400
                                   hover:text-gray-900
                                   flex items-center
                                   justify-center
                                   transition">

                        <i class="fa-solid fa-link text-sm"></i>

                    </button>

                </div>

            </div>

        </aside>

    </div>

</article>



{{-- =========================================================
    IMAGE MODAL
========================================================= --}}
<div id="imageModal"
     class="fixed inset-0
            z-50
            hidden
            items-center
            justify-center
            p-4
            bg-gray-950/90
            backdrop-blur-sm">

    {{-- Close --}}
    <button type="button"
            onclick="closeImageModal()"
            class="absolute
                   top-5
                   right-5
                   w-10 h-10
                   rounded-full
                   bg-white/10
                   text-white
                   hover:bg-white/20
                   flex items-center
                   justify-center
                   transition">

        <i class="fa-solid fa-xmark"></i>

    </button>


    <img id="modalImage"
         src=""
         alt="{{ $artikel->title }}"
         class="max-w-full
                max-h-[90vh]
                object-contain
                rounded-lg
                shadow-2xl">

</div>



{{-- =========================================================
    TOAST
========================================================= --}}
<div id="articleToast"
     class="fixed
            bottom-6
            left-1/2
            -translate-x-1/2
            z-[60]
            hidden
            items-center
            gap-2
            px-4 py-3
            rounded-xl
            bg-gray-950
            text-white
            text-sm
            font-semibold
            shadow-xl">

    <i class="fa-solid fa-circle-check
              text-cyan-400">
    </i>

    <span id="toastMessage"></span>

</div>



{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
<script>

function openImageModal(src) {

    const modal =
        document.getElementById('imageModal');

    const image =
        document.getElementById('modalImage');


    if (!modal || !image) {
        return;
    }


    image.src = src;

    modal.classList.remove('hidden');

    modal.classList.add('flex');

    document.body.classList.add(
        'overflow-hidden'
    );

}



function closeImageModal() {

    const modal =
        document.getElementById('imageModal');


    if (!modal) {
        return;
    }


    modal.classList.add('hidden');

    modal.classList.remove('flex');

    document.body.classList.remove(
        'overflow-hidden'
    );

}



document.getElementById('imageModal')
    ?.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeImageModal();

            }

        }
    );



/*
|--------------------------------------------------------------------------
| SHARE
|--------------------------------------------------------------------------
*/

function shareArticle() {

    const title =
        document.title;

    const url =
        window.location.href;


    if (navigator.share) {

        navigator.share({
            title: title,
            url: url
        });

        return;

    }


    copyArticleLink();

}



/*
|--------------------------------------------------------------------------
| COPY LINK
|--------------------------------------------------------------------------
*/

function copyArticleLink() {

    const url =
        window.location.href;


    if (
        navigator.clipboard &&
        window.isSecureContext
    ) {

        navigator.clipboard
            .writeText(url)
            .then(function () {

                showToast(
                    'Tautan artikel berhasil disalin.'
                );

            })
            .catch(function () {

                showToast(
                    'Gagal menyalin tautan.'
                );

            });

        return;

    }


    showToast(
        'Salin tautan secara manual dari browser.'
    );

}



/*
|--------------------------------------------------------------------------
| TOAST
|--------------------------------------------------------------------------
*/

function showToast(message) {

    const toast =
        document.getElementById(
            'articleToast'
        );

    const text =
        document.getElementById(
            'toastMessage'
        );


    if (!toast || !text) {
        return;
    }


    text.textContent = message;


    toast.classList.remove(
        'hidden'
    );

    toast.classList.add(
        'flex'
    );


    setTimeout(function () {

        toast.classList.add(
            'hidden'
        );

        toast.classList.remove(
            'flex'
        );

    }, 2500);

}



/*
|--------------------------------------------------------------------------
| ESC → CLOSE IMAGE
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key === 'Escape') {

            closeImageModal();

        }

    }
);

</script>



{{-- =========================================================
    RICH CONTENT
========================================================= --}}
<style>

.rich-content {

    font-size: 1.05rem;

    line-height: 1.9;

}


.rich-content p {

    margin-bottom: 1.4rem;

}


.rich-content h2 {

    margin-top: 2.5rem;

    margin-bottom: 1rem;

    font-size: 1.6rem;

    font-weight: 800;

    line-height: 1.3;

    color: #111827;

}


.rich-content h3 {

    margin-top: 2rem;

    margin-bottom: 0.8rem;

    font-size: 1.3rem;

    font-weight: 800;

    line-height: 1.4;

    color: #111827;

}


.rich-content strong {

    font-weight: 800;

    color: #111827;

}


.rich-content a {

    color: #0891b2;

    font-weight: 600;

    text-decoration: underline;

}


.rich-content ul {

    list-style-type: disc;

    padding-left: 1.5rem;

    margin-bottom: 1.4rem;

}


.rich-content ol {

    list-style-type: decimal;

    padding-left: 1.5rem;

    margin-bottom: 1.4rem;

}


.rich-content li {

    margin-bottom: 0.5rem;

}


.rich-content blockquote {

    margin: 1.8rem 0;

    padding: 1.2rem 1.4rem;

    border-left: 4px solid #facc15;

    background: #fefce8;

    color: #374151;

    font-style: italic;

    border-radius: 0 0.75rem 0.75rem 0;

}


.rich-content img {

    max-width: 100%;

    height: auto;

    margin: 1.8rem auto;

    border-radius: 1rem;

}


.rich-content table {

    width: 100%;

    margin: 1.8rem 0;

    border-collapse: collapse;

}


.rich-content th,
.rich-content td {

    border: 1px solid #e5e7eb;

    padding: 0.75rem;

    text-align: left;

}


.rich-content th {

    background: #f9fafb;

    font-weight: 700;

}

</style>

@endsection
```
