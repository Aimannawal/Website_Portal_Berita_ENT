<x-guest-layout>
    {{-- Brand --}}
    <a href="{{ route('public.index') }}" class="flex items-center gap-2">
        <span class="grid h-8 w-8 place-items-center rounded-lg bg-violet-600 text-sm font-black text-white">N</span>
        <span class="text-lg font-extrabold tracking-tight text-slate-900">NewsHub</span>
    </a>

    {{-- Heading --}}
    <div class="mt-10">
        <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-slate-900">
            Reset<br>Password
        </h1>
        <p class="mt-3 text-sm text-slate-500">Buat kata sandi baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   placeholder="nama@email.com"
                   class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="Kata sandi baru"
                   class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   placeholder="Ulangi kata sandi baru"
                   class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm text-slate-900 placeholder-slate-400 outline-none transition focus:border-violet-500 focus:ring-4 focus:ring-violet-100">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8">
            <button type="submit"
                    class="rounded-xl bg-violet-600 px-10 py-3 text-sm font-bold text-white shadow-lg shadow-violet-600/30 transition hover:bg-violet-700 focus:outline-none focus:ring-4 focus:ring-violet-200">
                Reset Password
            </button>
        </div>
    </form>

    {{-- Footer link --}}
    <p class="mt-auto pt-10 text-sm text-slate-500">
        <a href="{{ route('login') }}" class="font-bold text-violet-600 transition hover:text-violet-700">&larr; Kembali ke Sign In</a>
    </p>
</x-guest-layout>
