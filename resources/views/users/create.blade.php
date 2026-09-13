@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="px-5 py-8 lg:px-8">
    <div class="mb-6"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">People & access</p><h1 class="mt-1 text-2xl font-bold">Tambah user</h1><p class="mt-1 text-sm text-[#64748b]">Pilih divisi atau role. Field satunya akan terisi otomatis.</p></div>
    <form id="user-form" action="{{ route('wm.users.store') }}" method="POST" class="portal-card max-w-2xl space-y-5 p-6">
        @csrf
        <div><label for="name" class="mb-1 block text-sm font-semibold">Nama</label><input id="name" type="text" name="name" value="{{ old('name') }}" class="portal-input" required></div>
        <div><label for="email" class="mb-1 block text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" class="portal-input" required></div>
        <div><label for="password" class="mb-1 block text-sm font-semibold">Password</label><input id="password" type="password" name="password" class="portal-input" required></div>
        <div class="grid gap-4 md:grid-cols-2">
            <div><label for="division_id" class="mb-1 block text-sm font-semibold">Divisi</label><select id="division_id" name="division_id" class="portal-input"><option value="">Pilih divisi</option>@foreach ($divisions as $division)<option value="{{ $division->id }}" data-role="{{ str_replace('-', '_', $division->slug) }}" @selected(old('division_id') == $division->id)>{{ $division->name }}</option>@endforeach</select></div>
            <div><label for="role" class="mb-1 block text-sm font-semibold">Role</label><select id="role" name="role" class="portal-input"><option value="">Pilih role</option>@foreach ($roles as $role)<option value="{{ $role->name }}" data-division="{{ str_replace('_', '-', $role->name) }}" @selected(old('role') === $role->name)>{{ $role->name }}</option>@endforeach</select></div>
        </div>
        <p class="rounded-xl bg-[#f5f8fd] px-4 py-3 text-xs leading-5 text-[#64748b]">Divisi dan role harus menunjuk pasangan yang sama. Contoh: Webmaster otomatis menggunakan role <strong>webmaster</strong>.</p>
        <div class="flex items-center gap-3"><button class="portal-button portal-button-accent" type="submit">Simpan user</button><a href="{{ route('wm.users.index') }}" class="text-sm font-semibold text-[#64748b]">Batal</a></div>
    </form>
</div>
<script>
    const divisionField = document.getElementById('division_id');
    const roleField = document.getElementById('role');
    divisionField.addEventListener('change', () => {
        const option = divisionField.selectedOptions[0];
        roleField.value = option?.dataset.role || '';
    });
    roleField.addEventListener('change', () => {
        const option = roleField.selectedOptions[0];
        const divisionSlug = option?.dataset.division || '';
        const divisionOption = [...divisionField.options].find(item => item.dataset.role === option?.value);
        divisionField.value = divisionOption?.value || '';
    });
</script>
@endsection
