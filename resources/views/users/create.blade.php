@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah User</h1>

<form action="{{ route('wm.users.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Divisi</label>
        <select name="division_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Divisi --</option>
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id') == $division->id)>
                    {{ $division->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Role</label>
        <select name="role" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Role --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role') == $role->name)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('wm.users.index') }}" class="text-sm underline ml-2">Batal</a>
</form>
@endsection
