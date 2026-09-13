<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles & Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

            /* Panel ilustrasi ungu + awan */
            .auth-illustration {
                background: linear-gradient(160deg, #7c5cf0 0%, #8f63f4 45%, #7a4de8 100%);
                position: relative;
                overflow: hidden;
            }
            .auth-cloud {
                position: absolute;
                background: #fff;
                border-radius: 999px;
            }
            .auth-cloud::before,
            .auth-cloud::after {
                content: '';
                position: absolute;
                background: #fff;
                border-radius: 50%;
            }
            .auth-cloud-1 { width: 180px; height: 52px; top: 6%; left: -40px; }
            .auth-cloud-1::before { width: 70px; height: 70px; top: -34px; left: 24px; }
            .auth-cloud-1::after  { width: 46px; height: 46px; top: -22px; left: 82px; }
            .auth-cloud-2 { width: 150px; height: 44px; top: 16%; right: -30px; }
            .auth-cloud-2::before { width: 58px; height: 58px; top: -28px; left: 20px; }
            .auth-cloud-2::after  { width: 38px; height: 38px; top: -18px; left: 68px; }
            .auth-cloud-3 { width: 200px; height: 56px; bottom: 8%; left: -50px; }
            .auth-cloud-3::before { width: 80px; height: 80px; top: -38px; left: 28px; }
            .auth-cloud-3::after  { width: 50px; height: 50px; top: -24px; left: 96px; }
            .auth-cloud-4 { width: 140px; height: 40px; bottom: 20%; right: -24px; }
            .auth-cloud-4::before { width: 54px; height: 54px; top: -26px; left: 18px; }
            .auth-cloud-4::after  { width: 34px; height: 34px; top: -16px; left: 62px; }
        </style>
    </head>
    <body class="text-slate-900 antialiased">
        <div class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-8">
            {{-- Kartu utama rounded besar --}}
            <div class="grid w-full max-w-5xl overflow-hidden rounded-[28px] bg-white shadow-[0_25px_80px_rgba(15,23,42,.12)] lg:min-h-[620px] lg:grid-cols-2">

                {{-- Kolom kiri: konten halaman (form login) --}}
                <div class="flex flex-col px-8 py-10 sm:px-12">
                    {{ $slot }}
                </div>

                {{-- Kolom kanan: panel ilustrasi ungu --}}
                <div class="auth-illustration relative hidden items-center justify-center lg:flex">
                    <div class="auth-cloud auth-cloud-1"></div>
                    <div class="auth-cloud auth-cloud-2"></div>
                    <div class="auth-cloud auth-cloud-3"></div>
                    <div class="auth-cloud auth-cloud-4"></div>

                    {{-- Ilustrasi ponsel + fingerprint (SVG) --}}
                    <div class="relative z-10 w-full max-w-[340px] px-6">
                        <svg viewBox="0 0 320 360" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full drop-shadow-2xl">
                            {{-- Ponsel --}}
                            <rect x="70" y="30" width="180" height="300" rx="26" fill="#1e1b4b"/>
                            <rect x="80" y="40" width="160" height="280" rx="18" fill="#a855f7"/>
                            <rect x="80" y="40" width="160" height="280" rx="18" fill="url(#screenGrad)"/>
                            <defs>
                                <linearGradient id="screenGrad" x1="80" y1="40" x2="240" y2="320" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#c084fc"/>
                                    <stop offset="1" stop-color="#7c3aed"/>
                                </linearGradient>
                            </defs>
                            {{-- Notch --}}
                            <rect x="135" y="48" width="50" height="10" rx="5" fill="#1e1b4b"/>
                            {{-- Fingerprint --}}
                            <g stroke="#fff" stroke-width="5" stroke-linecap="round" opacity="0.9">
                                <path d="M135 150 a25 25 0 0 1 50 0"/>
                                <path d="M128 165 a32 32 0 0 1 64 0 v18"/>
                                <path d="M121 182 a39 39 0 0 1 39 -39"/>
                                <path d="M199 190 a39 39 0 0 0 -3 -16"/>
                                <path d="M160 152 v36"/>
                                <path d="M147 158 v40"/>
                                <path d="M173 158 v40"/>
                                <path d="M140 200 q20 14 40 0"/>
                            </g>
                            {{-- Teks kecil di layar --}}
                            <text x="160" y="250" text-anchor="middle" fill="#fff" font-size="11" opacity="0.8" font-family="Inter, sans-serif">Sentuh sensor sidik jari</text>
                            <text x="160" y="266" text-anchor="middle" fill="#fff" font-size="11" opacity="0.8" font-family="Inter, sans-serif">untuk masuk</text>
                            {{-- Progress bar --}}
                            <rect x="110" y="284" width="100" height="8" rx="4" fill="#ffffff" opacity="0.35"/>
                            <rect x="110" y="284" width="62" height="8" rx="4" fill="#fff"/>

                            {{-- Gembok --}}
                            <g transform="translate(225,190) rotate(8)">
                                <rect x="0" y="28" width="64" height="56" rx="10" fill="#fff"/>
                                <path d="M14 28 v-8 a18 18 0 0 1 36 0 v8" stroke="#fff" stroke-width="10" fill="none" stroke-linecap="round"/>
                                <circle cx="32" cy="50" r="8" fill="#8b5cf6"/>
                                <rect x="29" y="52" width="6" height="16" rx="3" fill="#8b5cf6"/>
                            </g>

                            {{-- Bubble centang --}}
                            <g transform="translate(30,60)">
                                <ellipse cx="42" cy="34" rx="42" ry="30" fill="#fff"/>
                                <path d="M18 44 L2 62 L26 52 Z" fill="#fff"/>
                                <path d="M26 34 l10 11 l20 -22" stroke="#8b5cf6" stroke-width="7" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                        </svg>

                        {{-- Badge teks --}}
                        <div class="mt-6 text-center">
                            <p class="text-lg font-extrabold text-white">Portal Berita ENT GEN 21</p>
                            <p class="mt-1 text-sm text-purple-200">Masuk dengan aman ke ruang kerja redaksi Anda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
