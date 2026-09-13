<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-600">
            <i class="fa-solid fa-newspaper text-2xl"></i>
        </div>

```
    <p class="text-xs font-bold uppercase tracking-[.18em] text-cyan-600">
        Portal Berita — Internal
    </p>

    <h1 class="mt-2 text-2xl font-bold text-gray-900">
        Selamat datang kembali
    </h1>

    <p class="mt-2 text-sm leading-6 text-gray-500">
        Masuk untuk mengelola konten dan pekerjaan tim.
    </p>
</div>

<!-- Session Status -->
<x-auth-session-status
    class="mb-4"
    :status="session('status')"
/>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div>
        <x-input-label
            for="email"
            :value="__('Email')"
            class="font-semibold text-gray-700"
        />

        <div class="relative mt-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-envelope"></i>
            </span>

            <x-text-input
                id="email"
                class="portal-input block w-full pl-11"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@email.com"
            />
        </div>

        <x-input-error
            :messages="$errors->get('email')"
            class="mt-2"
        />
    </div>

    <!-- Password -->
    <div class="mt-5">
        <x-input-label
            for="password"
            :value="__('Password')"
            class="font-semibold text-gray-700"
        />

        <div class="relative mt-1">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                <i class="fa-solid fa-lock"></i>
            </span>

            <x-text-input
                id="password"
                class="portal-input block w-full pl-11 pr-11"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
            />

            <button
                type="button"
                id="togglePassword"
                class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 transition hover:text-cyan-600"
                aria-label="Tampilkan password"
            >
                <i class="fa-solid fa-eye" id="passwordIcon"></i>
            </button>
        </div>

        <x-input-error
            :messages="$errors->get('password')"
            class="mt-2"
        />
    </div>

    <!-- Remember Me -->
    <div class="mt-5">
        <label
            for="remember_me"
            class="inline-flex cursor-pointer items-center"
        >
            <input
                id="remember_me"
                type="checkbox"
                class="rounded border-gray-300 text-cyan-600 shadow-sm focus:ring-cyan-500"
                name="remember"
            >

            <span class="ms-2 text-sm text-gray-500">
                Ingat saya
            </span>
        </label>
    </div>

    <!-- Login Button -->
    <div class="mt-6">
        <x-primary-button
            class="portal-button portal-button-accent w-full justify-center border-0 bg-cyan-600 py-3 text-sm font-semibold shadow-sm transition hover:bg-cyan-700"
        >
            <i class="fa-solid fa-right-to-bracket mr-2"></i>
            Masuk ke Workspace
        </x-primary-button>
    </div>
</form>

<div class="mt-7 flex items-center gap-3">
    <div class="h-px flex-1 bg-gray-200"></div>

    <span class="text-[11px] font-medium uppercase tracking-wider text-gray-400">
        Internal Access
    </span>

    <div class="h-px flex-1 bg-gray-200"></div>
</div>

<p class="mt-4 text-center text-xs leading-5 text-gray-400">
    Akses ini ditujukan untuk anggota tim pengelola
    dan administrasi Portal Berita.
</p>
```

</x-guest-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (togglePassword && password && passwordIcon) {
        togglePassword.addEventListener('click', function () {
            if (password.type == 'password') {
                password.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
                togglePassword.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                password.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
                togglePassword.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    }
});
</script>
