<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center bg-[#f5f8fd] px-4 py-10">
            <div class="w-full max-w-md">
                <a href="{{ route('public.index') }}" class="mb-6 block text-center">
                    <span class="text-2xl font-bold tracking-tight text-[#182338]">Portal Berita</span>
                    <span class="mt-1 block text-xs font-semibold uppercase tracking-[.22em] text-[#6d94d3]">ENT GEN 21</span>
                </a>
                <div class="rounded-[22px] border border-[#dce6f5] bg-white px-6 py-7 shadow-[0_18px_50px_rgba(72,103,156,.12)] sm:px-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
