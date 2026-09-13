@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit User: {{ $user->name }}</h1>

<form action="{{ route('wm.users.update', $user) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Password (kosongkan kalau tidak diganti)</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Divisi</label>
        <select name="division_id" class="w-full border rounded px-3 py-2">
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id', $user->division_id) == $division->id)>
                    {{ $division->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Role</label>
        <select name="role" class="w-full border rounded px-3 py-2">
            @foreach ($roles as $role)
                <option value="{{ $role->name }}" @selected(old('role', $user->roles->first()?->name) == $role->name)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Update</button>
    <a href="{{ route('wm.users.index') }}" class="text-sm underline ml-2">Batal</a>
</form>
@endsection
