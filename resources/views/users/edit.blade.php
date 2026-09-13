@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="px-5 py-8 lg:px-8">
    <div class="mb-6"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">People & access</p><h1 class="mt-1 text-2xl font-bold">Edit user: {{ $user->name }}</h1><p class="mt-1 text-sm text-[#64748b]">Pilih divisi atau role. Field satunya akan terisi otomatis.</p></div>
    <form id="user-form" action="{{ route('wm.users.update', $user) }}" method="POST" class="portal-card max-w-2xl space-y-5 p-6">
        @csrf
        @method('PUT')
        <div><label for="name" class="mb-1 block text-sm font-semibold">Nama</label><input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="portal-input" required></div>
        <div><label for="email" class="mb-1 block text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="portal-input" required></div>
        <div><label for="password" class="mb-1 block text-sm font-semibold">Password <span class="font-normal text-[#94a3b8]">(opsional)</span></label><input id="password" type="password" name="password" class="portal-input"></div>
        <div class="grid gap-4 md:grid-cols-2">
            <div><label for="division_id" class="mb-1 block text-sm font-semibold">Divisi</label><select id="division_id" name="division_id" class="portal-input"><option value="">Pilih divisi</option>@foreach ($divisions as $division)<option value="{{ $division->id }}" data-role="{{ str_replace('-', '_', $division->slug) }}" @selected(old('division_id', $user->division_id) == $division->id)>{{ $division->name }}</option>@endforeach</select></div>
            <div><label for="role" class="mb-1 block text-sm font-semibold">Role</label><select id="role" name="role" class="portal-input"><option value="">Pilih role</option>@foreach ($roles as $role)<option value="{{ $role->name }}" data-division="{{ str_replace('_', '-', $role->name) }}" @selected(old('role', $user->roles->first()?->name) === $role->name)>{{ $role->name }}</option>@endforeach</select></div>
        </div>
        <p class="rounded-xl bg-[#f5f8fd] px-4 py-3 text-xs leading-5 text-[#64748b]">Divisi dan role harus menunjuk pasangan yang sama. Mengubah salah satunya otomatis mengubah field lainnya.</p>
        <div class="flex items-center gap-3"><button class="portal-button portal-button-accent" type="submit">Update user</button><a href="{{ route('wm.users.index') }}" class="text-sm font-semibold text-[#64748b]">Batal</a></div>
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
        const divisionOption = [...divisionField.options].find(item => item.dataset.role === option?.value);
        divisionField.value = divisionOption?.value || '';
    });
</script>
@endsection
