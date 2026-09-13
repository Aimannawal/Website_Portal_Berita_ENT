<x-guest-layout>
    {{-- Brand --}}
    <a href="{{ route('public.index') }}" class="flex items-center gap-2">
        <span class="grid h-8 w-8 place-items-center rounded-lg bg-violet-600 text-sm font-black text-white">N</span>
        <span class="text-lg font-extrabold tracking-tight text-slate-900">NewsHub</span>
    </a>

    {{-- Heading --}}
    <div class="mt-12 lg:mt-16">
        <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-slate-900">
            Holla,<br>Welcome Back
        </h1>
        <p class="mt-3 text-sm text-slate-500">Hey, selamat datang kembali di ruang kerja redaksi Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8">
        @csrf

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="nama@email.com"
                   class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••••••"
                   class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="mt-4 flex items-center justify-between">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember"
                       class="h-4 w-4 rounded border-slate-300 text-violet-600 accent-violet-600 focus:ring-violet-500">
                <span class="text-sm text-slate-500">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-slate-500 transition hover:text-violet-600">
                    Forgot Password?
                </a>
            @endif
        </div>

        <!-- Sign In -->
        <div class="mt-8">
            <button type="submit"
                    class="rounded-xl bg-violet-600 px-10 py-3 text-sm font-bold text-white shadow-lg shadow-violet-600/30 transition hover:bg-violet-700 focus:outline-none focus:ring-4 focus:ring-violet-200">
                Sign In
            </button>
        </div>
    </form>

    {{-- Footer link --}}
    <p class="mt-auto pt-10 text-sm text-slate-500">
        Belum punya akun?
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-bold text-violet-600 transition hover:text-violet-700">Sign Up</a>
        @else
            <span class="font-semibold text-slate-700">hubungi webmaster</span>
        @endif
    </p>
</x-guest-layout>
