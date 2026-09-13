@extends('layouts.app')
@section('title', 'Kelola User')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kelola User</h1>
    <a href="{{ route('wm.users.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah User</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Email</th>
                <th class="p-3">Divisi</th>
                <th class="p-3">Role</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($users as $user)
                <tr>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->division?->name ?? '-' }}</td>
                    <td class="p-3">{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('wm.users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('wm.users.destroy', $user) }}" method="POST" class="inline"
                              onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
