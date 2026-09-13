<x-guest-layout>
    <div class="mb-7">
        <p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">Workspace internal</p>
        <h1 class="mt-2 text-2xl font-bold text-[#182338]">Selamat datang kembali</h1>
        <p class="mt-2 text-sm leading-6 text-[#64748b]">Masuk untuk mengelola konten dan pekerjaan tim.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="portal-input mt-1 block" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="portal-input mt-1 block"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-[#dce6f5] text-[#92b4ec] focus:ring-[#92b4ec]" name="remember">
                <span class="ms-2 text-sm text-[#64748b]">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="portal-button portal-button-accent ms-3 border-0">
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
