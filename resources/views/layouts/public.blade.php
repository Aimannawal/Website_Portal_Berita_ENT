<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'NewsHub — Portal Berita WM')</title>
    <meta name="description" content="@yield('meta_description', 'Portal berita ENT GEN 21 — kabar terkini, artikel pilihan, dan sorotan mingguan dari redaksi kami.')">
    <meta property="og:title" content="@yield('title', 'NewsHub — Portal Berita WM')">
    <meta property="og:description" content="@yield('meta_description', 'Portal berita ENT GEN 21 — kabar terkini, artikel pilihan, dan sorotan mingguan dari redaksi kami.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', asset('images/placeholder.svg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="alternate" type="application/rss+xml" title="RSS NewsHub" href="{{ route('public.feed') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        @keyframes ticker-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-track { animation: ticker-scroll 30s linear infinite; }
        .ticker-track:hover { animation-play-state: paused; }
    </style>
    @stack('head')
</head>
<body class="bg-white font-sans text-slate-900 antialiased">

    {{-- ===== Navbar ===== --}}
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur" x-data="{ mobileOpen: false }">
        <div class="mx-auto flex h-14 max-w-7xl items-center justify-between gap-6 px-4 sm:px-6">
            <a href="{{ route('public.index') }}" class="text-xl font-extrabold tracking-tight">
                News<span class="text-red-600">Hub</span>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-700 lg:flex">
                <a href="{{ route('public.index') }}" class="transition hover:text-red-600">Beranda</a>
                @foreach ($navCategories ?? [] as $navCategory)
                    <a href="{{ route('public.index', ['kategori' => $navCategory->slug]) }}"
                       class="transition hover:text-red-600">{{ $navCategory->name }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2">
                <form action="{{ route('public.index') }}" method="GET" class="hidden md:block">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                           class="w-44 rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-sm outline-none transition focus:border-slate-400 focus:bg-white">
                </form>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="rounded-full bg-slate-900 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-slate-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-full bg-slate-900 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-slate-700">Masuk</a>
                @endauth
                <button type="button" @click="mobileOpen = !mobileOpen"
                        class="grid h-9 w-9 place-items-center rounded-full border border-slate-200 transition hover:bg-slate-50 lg:hidden" aria-label="Menu">
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <div x-show="mobileOpen" x-cloak x-transition.opacity
             class="border-t border-slate-100 bg-white lg:hidden">
            <nav class="mx-auto max-w-7xl space-y-1 px-4 py-3 sm:px-6">
                <form action="{{ route('public.index') }}" method="GET" class="pb-2 md:hidden">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..."
                           class="w-full rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm outline-none focus:border-slate-400 focus:bg-white">
                </form>
                <a href="{{ route('public.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-red-600">Beranda</a>
                @foreach ($navCategories ?? [] as $navCategory)
                    <a href="{{ route('public.index', ['kategori' => $navCategory->slug]) }}"
                       class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 hover:text-red-600">{{ $navCategory->name }}</a>
                @endforeach
            </nav>
        </div>

        {{-- Ticker berita terkini --}}
        @if (!empty($tickerItems) && count($tickerItems))
        <div class="border-t border-slate-100 bg-slate-50" aria-hidden="true">
            <div class="mx-auto flex max-w-7xl items-center gap-3 overflow-hidden px-4 py-1.5 sm:px-6">
                <span class="shrink-0 rounded bg-red-600 px-2 py-0.5 text-[11px] font-bold uppercase tracking-wide text-white">Terkini</span>
                <div class="relative flex-1 overflow-hidden">
                    <div class="ticker-track flex w-max gap-10 whitespace-nowrap text-xs text-slate-600">
                        @foreach ($tickerItems->concat($tickerItems) as $ticker)
                            <span>{{ $ticker->title }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
        @yield('content')
    </main>

    {{-- ===== Footer ===== --}}
    <footer class="mt-12 border-t border-slate-200 bg-slate-50">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-[2fr_1fr_1fr_1fr]">
            <div>
                <a href="{{ route('public.index') }}" class="text-xl font-extrabold tracking-tight">
                    News<span class="text-red-600">Hub</span>
                </a>
                <p class="mt-3 max-w-xs text-sm leading-relaxed text-slate-500">
                    Portal berita ENT GEN 21 — menyajikan kabar terkini, artikel pilihan, dan sorotan mingguan dari redaksi kami.
                </p>
                @if (session('newsletter_success'))
                    <p class="mt-5 max-w-xs rounded-lg bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('newsletter_success') }}
                    </p>
                @else
                    <form action="{{ route('public.subscribe') }}" method="POST" class="mt-5 max-w-xs">
                        @csrf
                        <div class="flex">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Alamat email Anda" required
                                   class="w-full rounded-l-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-slate-500">
                            <button type="submit" class="rounded-r-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700">
                                Langganan
                            </button>
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </form>
                @endif
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900">Konten</h4>
                <ul class="mt-4 space-y-2 text-sm text-slate-500">
                    <li><a href="{{ route('public.index') }}" class="transition hover:text-red-600">Beranda</a></li>
                    @foreach ($navCategories ?? [] as $navCategory)
                        <li><a href="{{ route('public.index', ['kategori' => $navCategory->slug]) }}" class="transition hover:text-red-600">{{ $navCategory->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900">Perusahaan</h4>
                <ul class="mt-4 space-y-2 text-sm text-slate-500">
                    <li><a href="{{ route('public.page', 'tentang-kami') }}" class="transition hover:text-red-600">Tentang Kami</a></li>
                    <li><a href="{{ route('public.page', 'karier') }}" class="transition hover:text-red-600">Karier</a></li>
                    <li><a href="{{ route('public.page', 'media-kit') }}" class="transition hover:text-red-600">Media Kit</a></li>
                    <li><a href="{{ route('public.page', 'kontak') }}" class="transition hover:text-red-600">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-slate-900">Bantuan</h4>
                <ul class="mt-4 space-y-2 text-sm text-slate-500">
                    <li><a href="{{ route('public.page', 'faq') }}" class="transition hover:text-red-600">FAQ</a></li>
                    <li><a href="{{ route('public.page', 'kebijakan-privasi') }}" class="transition hover:text-red-600">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('public.page', 'syarat-ketentuan') }}" class="transition hover:text-red-600">Syarat &amp; Ketentuan</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-200 py-5 text-center text-xs text-slate-400">
            &copy; {{ date('Y') }} NewsHub — Portal Berita ENT GEN 21. Seluruh hak cipta dilindungi.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
