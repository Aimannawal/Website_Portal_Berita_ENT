@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="px-5 py-8 lg:px-8">
    <div class="mb-6"><p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">People & access</p><h1 class="mt-1 text-2xl font-bold">Edit user: {{ $user->name }}</h1><p class="mt-1 text-sm text-[#64748b]">Pilih divisi. Role akan diatur otomatis oleh sistem.</p></div>
    <form id="user-form" action="{{ route('wm.users.update', $user) }}" method="POST" class="portal-card max-w-2xl space-y-5 p-6">
        @csrf
        @method('PUT')
        <div><label for="name" class="mb-1 block text-sm font-semibold">Nama</label><input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="portal-input" required></div>
        <div><label for="email" class="mb-1 block text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="portal-input" required></div>
        <div><label for="password" class="mb-1 block text-sm font-semibold">Password <span class="font-normal text-[#94a3b8]">(opsional)</span></label><input id="password" type="password" name="password" class="portal-input"></div>
        <div><label for="division_id" class="mb-1 block text-sm font-semibold">Divisi</label><select id="division_id" name="division_id" class="portal-input" required><option value="">Pilih divisi</option>@foreach ($divisions as $division)<option value="{{ $division->id }}" @selected(old('division_id', $user->division_id) == $division->id)>{{ $division->name }}</option>@endforeach</select><p class="mt-1 text-xs text-[#64748b]">Role otomatis mengikuti divisi yang dipilih.</p></div>
        <div class="flex items-center gap-3"><button class="portal-button portal-button-accent" type="submit">Update user</button><a href="{{ route('wm.users.index') }}" class="text-sm font-semibold text-[#64748b]">Batal</a></div>
    </form>
 </div>
@endsection
