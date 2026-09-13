<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Berita WM')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f8fd] text-[#182338]">
    <header class="border-b border-[#dce6f5] bg-white">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
            <a href="{{ route('public.index') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-[#92b4ec] text-sm font-bold">PB</span>
                <span>
                    <span class="block text-base font-bold leading-tight">Portal Berita</span>
                    <span class="block text-[10px] font-semibold uppercase tracking-[.2em] text-[#6d94d3]">ENT GEN 21</span>
                </span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="rounded-lg bg-[#92b4ec] px-4 py-2 text-xs font-bold text-[#182338]">Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="rounded-lg bg-[#ffd24c] px-4 py-2 text-xs font-bold text-[#182338]">Masuk</a>
            @endauth
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-5 py-8">
        @yield('content')
    </main>

    <footer class="py-8 text-center text-xs text-[#94a3b8]">
        &copy; {{ date('Y') }} Portal Berita ENT GEN 21
    </footer>
</body>
</html>
