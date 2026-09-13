```blade
@extends('layouts.public')

@section('title', $berita->title)

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
    ARTICLE HEADER
========================================================= --}}
<article>

    {{-- Category + Date --}}
    <div class="flex flex-wrap items-center
                gap-2 mb-4">

        <span class="inline-flex items-center
                     px-3 py-1.5
                     rounded-lg
                     bg-cyan-50
                     text-cyan-700
                     text-xs font-black">

            <i class="fa-solid fa-tag mr-2 text-[10px]"></i>

            {{ $berita->category?->name ?? 'Umum' }}

        </span>


        @if ($berita->published_at)

            <span class="w-1 h-1
                         rounded-full
                         bg-gray-300">
            </span>


            <span class="inline-flex items-center gap-1.5
                         text-xs
                         text-gray-500">

                <i class="fa-regular fa-calendar"></i>

                {{ $berita->published_at->format('d M Y') }}

            </span>

        @endif

    </div>



    {{-- Title --}}
    <h1 class="max-w-5xl
               text-3xl md:text-4xl lg:text-5xl
               font-black
               tracking-tight
               leading-tight
               text-gray-950">

        {{ $berita->title }}

    </h1>



    {{-- Author --}}
    <div class="flex flex-wrap
                items-center
                justify-between
                gap-4
                mt-6 pb-6
                border-b border-gray-200">

        <div class="flex items-center gap-3">

            {{-- Avatar --}}
            <div class="w-10 h-10
                        rounded-full
                        bg-cyan-600
                        text-white
                        flex items-center
                        justify-center
                        font-black">

                <i class="fa-solid fa-user"></i>

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

                    {{ $berita->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}

                </p>

            </div>

        </div>


        {{-- Article Type --}}
        <div class="hidden sm:flex
                    items-center gap-2
                    text-xs
                    text-gray-400">

            <i class="fa-regular fa-newspaper"></i>

            Berita

        </div>

    </div>



    {{-- =====================================================
        IMAGE GALLERY
    ====================================================== --}}
    @if ($berita->images->isNotEmpty())

        <div class="mt-8 mb-10">

            @if ($berita->images->count() == 1)

                {{-- Single Image --}}
                @php
                    $image = $berita->images->first();
                @endphp

                <div class="relative
                            rounded-2xl
                            overflow-hidden
                            bg-gray-100">

                    <img
                        src="{{ asset('storage/' . $image->file_path) }}"
                        alt="{{ $berita->title }}"
                        class="w-full
                               max-h-[650px]
                               object-cover
                               cursor-zoom-in
                               hover:scale-[1.01]
                               transition-transform duration-500"
                        onclick="openImageModal(this.src)"
                    >

                </div>

            @else

                {{-- Multiple Images --}}
                <div class="grid
                            md:grid-cols-2
                            gap-3">

                    @foreach ($berita->images as $image)

                        <div class="relative
                                    rounded-2xl
                                    overflow-hidden
                                    bg-gray-100
                                    group">

                            <img
                                src="{{ asset('storage/' . $image->file_path) }}"
                                alt="{{ $berita->title }}"
                                class="w-full
                                       h-72 md:h-80
                                       object-cover
                                       cursor-zoom-in
                                       group-hover:scale-105
                                       transition-transform
                                       duration-500"
                                onclick="openImageModal(this.src)"
                            >

                            {{-- Overlay --}}
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


            {{-- Caption --}}
            <p class="flex items-center gap-2
                      mt-3
                      text-xs
                      text-gray-400">

                <i class="fa-regular fa-image"></i>

                Dokumentasi dan gambar terkait berita

            </p>

        </div>

    @endif



    {{-- =====================================================
        ARTICLE BODY
    ====================================================== --}}
    <div class="grid lg:grid-cols-[1fr_260px]
                gap-10
                items-start">

        {{-- Content --}}
        <div>

            {{-- Lead Accent --}}
            <div class="flex items-start gap-4 mb-7">

                <span class="shrink-0
                             w-1
                             min-h-[60px]
                             rounded-full
                             bg-yellow-400">
                </span>


                <p class="text-lg
                          md:text-xl
                          font-semibold
                          text-gray-700
                          leading-relaxed">

                    {{ $berita->excerpt }}

                </p>

            </div>


            {{-- Rich Content --}}
            <div class="rich-content
                        max-w-none
                        text-gray-800">

                {!! $berita->content !!}

            </div>

        </div>



        {{-- =================================================
            SIDEBAR
        ================================================== --}}
        <aside class="lg:sticky lg:top-24">

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

                    Tentang Berita

                </p>


                <div class="space-y-4">

                    {{-- Category --}}
                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8
                                    shrink-0
                                    rounded-lg
                                    bg-cyan-100
                                    text-cyan-600
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

                                {{ $berita->category?->name ?? 'Umum' }}

                            </p>

                        </div>

                    </div>


                    {{-- Date --}}
                    @if ($berita->published_at)

                        <div class="flex items-start gap-3">

                            <div class="w-8 h-8
                                        shrink-0
                                        rounded-lg
                                        bg-yellow-100
                                        text-yellow-600
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

                                    {{ $berita->published_at->format('d M Y') }}

                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- Author --}}
                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8
                                    shrink-0
                                    rounded-lg
                                    bg-cyan-100
                                    text-cyan-600
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

                                {{ $berita->penulis->pluck('name')->join(', ') ?: 'Redaksi' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>



            {{-- Share --}}
            <div class="mt-4
                        rounded-2xl
                        bg-cyan-600
                        p-5
                        text-white">

                <p class="text-xs
                          font-black
                          uppercase
                          tracking-wider">

                    Bagikan

                </p>

                <p class="text-xs
                          text-cyan-100
                          mt-1 mb-4">

                    Sebarkan berita ini kepada orang lain.

                </p>


                <div class="flex gap-2">

                    <button type="button"
                            onclick="shareArticle()"
                            class="flex-1
                                   h-9
                                   rounded-lg
                                   bg-white/10
                                   hover:bg-white/20
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
                                   hover:bg-white/20
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

    <button type="button"
            onclick="closeImageModal()"
            class="absolute
                   top-5 right-5
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
         alt="{{ $berita->title }}"
         class="max-w-full
                max-h-[90vh]
                object-contain
                rounded-lg
                shadow-2xl">

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

    document.body.classList.add('overflow-hidden');

}


function closeImageModal() {

    const modal =
        document.getElementById('imageModal');


    if (!modal) {
        return;
    }


    modal.classList.add('hidden');

    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');

}


document.getElementById('imageModal')
    ?.addEventListener('click', function (event) {

        if (event.target === this) {

            closeImageModal();

        }

    });



/*
|--------------------------------------------------------------------------
| SHARE ARTICLE
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
| COPY ARTICLE LINK
|--------------------------------------------------------------------------
*/

function copyArticleLink() {

    const url =
        window.location.href;


    navigator.clipboard.writeText(url)
        .then(function () {

            showToast(
                'Tautan berita berhasil disalin.'
            );

        })
        .catch(function () {

            showToast(
                'Gagal menyalin tautan.'
            );

        });

}



/*
|--------------------------------------------------------------------------
| TOAST
|--------------------------------------------------------------------------
*/

function showToast(message) {

    const oldToast =
        document.getElementById('articleToast');


    if (oldToast) {
        oldToast.remove();
    }


    const toast =
        document.createElement('div');


    toast.id = 'articleToast';


    toast.className =
        'fixed bottom-6 left-1/2 -translate-x-1/2 z-[60] ' +
        'flex items-center gap-2 px-4 py-3 rounded-xl ' +
        'bg-gray-950 text-white text-sm font-semibold ' +
        'shadow-xl';


    toast.innerHTML =
        '<i class="fa-solid fa-circle-check text-cyan-400"></i>' +
        '<span>' + message + '</span>';


    document.body.appendChild(toast);


    setTimeout(function () {

        toast.remove();

    }, 2500);

}



/*
|--------------------------------------------------------------------------
| ESC TO CLOSE IMAGE
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
    RICH CONTENT STYLE
========================================================= --}}
<style>

.rich-content {
    font-size: 1rem;
    line-height: 1.9;
}


.rich-content p {
    margin-bottom: 1.25rem;
}


.rich-content h2 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1.3;
    color: #111827;
}


.rich-content h3 {
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
    font-size: 1.25rem;
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
    margin-bottom: 1.25rem;
}


.rich-content ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.25rem;
}


.rich-content li {
    margin-bottom: 0.5rem;
}


.rich-content blockquote {
    margin: 1.5rem 0;
    padding: 1rem 1.25rem;
    border-left: 4px solid #06b6d4;
    background: #ecfeff;
    color: #374151;
    font-style: italic;
    border-radius: 0 0.75rem 0.75rem 0;
}


.rich-content img {
    max-width: 100%;
    height: auto;
    margin: 1.5rem auto;
    border-radius: 1rem;
}


.rich-content table {
    width: 100%;
    margin: 1.5rem 0;
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
