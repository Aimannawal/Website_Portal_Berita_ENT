@php
    use Illuminate\Support\Str;

    // $item      : model Berita/Artikel
    // $related   : koleksi konten terkait
    // $typeLabel : 'Berita' | 'Artikel'
    // $indexRoute / $showRouteName : nama route

    $readTime = max(1, (int) ceil(str_word_count(strip_tags($item->content ?? '')) / 200)) . ' min read';
    $cover = $item->images->isNotEmpty()
        ? $item->images->first()->url
        : ($item->thumbnail ? asset('storage/' . $item->thumbnail) : asset('images/placeholder.svg'));
    $authors = $item->penulis->pluck('name')->join(', ') ?: 'Redaksi';
    $shareUrl = urlencode(url()->current());
    $shareTitle = urlencode($item->title);
    $thumbOf = fn ($r) => $r->images->isNotEmpty()
        ? $r->images->first()->url
        : ($r->thumbnail ? asset('storage/' . $r->thumbnail) : asset('images/placeholder.svg'));
@endphp

{{-- Structured data (schema.org Article) --}}
@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $item->title,
    'description' => Str::limit(strip_tags($item->excerpt ?: $item->content), 200),
    'image' => [$cover],
    'datePublished' => $item->published_at?->toAtomString(),
    'dateModified' => $item->updated_at?->toAtomString(),
    'author' => $item->penulis->map(fn ($p) => ['@type' => 'Person', 'name' => $p->name])->values()->all() ?: [['@type' => 'Organization', 'name' => 'Redaksi NewsHub']],
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'NewsHub — Portal Berita ENT GEN 21',
        'logo' => ['@type' => 'ImageObject', 'url' => asset('images/placeholder.svg')],
    ],
    'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => url()->current()],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

{{-- Breadcrumb --}}
<nav class="mb-6 flex items-center gap-2 text-xs text-slate-500" aria-label="Breadcrumb">
    <a href="{{ route('public.index') }}" class="transition hover:text-red-600">Beranda</a>
    <span>&rsaquo;</span>
    <span>{{ $typeLabel }}</span>
    <span>&rsaquo;</span>
    <span class="max-w-[200px] truncate font-medium text-slate-700 sm:max-w-md">{{ $item->title }}</span>
</nav>

<div class="grid gap-10 lg:grid-cols-3">
    {{-- Kolom utama --}}
    <article class="lg:col-span-2">
        <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
            <span class="rounded bg-red-600 px-2 py-0.5 uppercase tracking-wide text-white">
                {{ $item->category?->name ?? 'Umum' }}
            </span>
            <span class="text-slate-400">{{ $item->published_at?->translatedFormat('d F Y') }}</span>
            <span class="text-slate-300">&middot;</span>
            <span class="text-slate-400">{{ $readTime }}</span>
            <span class="text-slate-300">&middot;</span>
            <span class="flex items-center gap-1 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ number_format($item->views ?? 0) }}x dibaca
            </span>
        </div>

        <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-4xl">
            {{ $item->title }}
        </h1>

        @if ($item->excerpt)
            <p class="mt-3 text-base leading-relaxed text-slate-500">{{ $item->excerpt }}</p>
        @endif

        {{-- Penulis --}}
        <div class="mt-5 flex items-center gap-3 border-y border-slate-100 py-4">
            <span class="grid h-10 w-10 place-items-center rounded-full bg-slate-900 text-sm font-bold text-white">
                {{ strtoupper(Str::substr($item->penulis->first()?->name ?? 'R', 0, 1)) }}
            </span>
            <div>
                <p class="text-sm font-bold text-slate-900">{{ $authors }}</p>
                <p class="text-xs text-slate-400">Redaksi NewsHub</p>
            </div>
        </div>

        {{-- Gambar utama --}}
        <figure class="mt-6 overflow-hidden rounded-2xl">
            <img src="{{ $cover }}" alt="{{ $item->title }}" class="w-full object-cover">
        </figure>

        {{-- Galeri tambahan --}}
        @if ($item->images->count() > 1)
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                @foreach ($item->images->skip(1) as $image)
                    <img src="{{ $image->url }}" alt="{{ $image->original_name ?? $item->title }}"
                         class="w-full rounded-xl object-cover">
                @endforeach
            </div>
        @endif

        {{-- Isi konten --}}
        <div class="rich-content mt-8 max-w-none">
            {!! $item->content !!}
        </div>

        {{-- Bagikan --}}
        <div class="mt-10 rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <p class="text-sm font-bold text-slate-900">Bagikan {{ strtolower($typeLabel) }} ini</p>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener"
                   class="rounded-full bg-[#25D366] px-4 py-2 text-xs font-bold text-white transition hover:opacity-90">WhatsApp</a>
                <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank" rel="noopener"
                   class="rounded-full bg-slate-900 px-4 py-2 text-xs font-bold text-white transition hover:opacity-90">X / Twitter</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
                   class="rounded-full bg-[#1877F2] px-4 py-2 text-xs font-bold text-white transition hover:opacity-90">Facebook</a>
                <a href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener"
                   class="rounded-full bg-[#229ED9] px-4 py-2 text-xs font-bold text-white transition hover:opacity-90">Telegram</a>
                <button type="button" onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { this.textContent = 'Tersalin!'; setTimeout(() => this.textContent = 'Salin Tautan', 1500); })"
                        class="rounded-full border border-slate-300 bg-white px-4 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-100">
                    Salin Tautan
                </button>
            </div>
        </div>
    </article>

    {{-- Sidebar konten terkait --}}
    <aside>
        <div class="lg:sticky lg:top-24">
            <h3 class="mb-4 text-lg font-extrabold tracking-tight">{{ $typeLabel }} Terkait</h3>
            <div class="space-y-4">
                @forelse ($related as $r)
                    <a href="{{ route($showRouteName, $r->slug) }}" class="group flex gap-3">
                        <img src="{{ $thumbOf($r) }}" alt="{{ $r->title }}"
                             class="h-16 w-20 shrink-0 rounded-lg object-cover">
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold text-red-600">{{ $r->category?->name ?? 'Umum' }}</p>
                            <h4 class="mt-0.5 line-clamp-2 text-sm font-bold leading-snug transition group-hover:text-red-600">
                                {{ $r->title }}
                            </h4>
                            <p class="mt-1 text-[11px] text-slate-400">{{ $r->published_at?->diffForHumans() }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-slate-400">Belum ada {{ strtolower($typeLabel) }} terkait.</p>
                @endforelse
            </div>

            <a href="{{ route('public.index') }}"
               class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-slate-600 transition hover:text-red-600">
                &larr; Kembali ke beranda
            </a>
        </div>
    </aside>
</div>
