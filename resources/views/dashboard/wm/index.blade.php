@extends('layouts.app')
@section('title', 'Dashboard Webmaster')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Webmaster</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total User</p>
        <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Berita</p>
        <p class="text-2xl font-bold">{{ $stats['total_berita'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Artikel</p>
        <p class="text-2xl font-bold">{{ $stats['total_artikel'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Task Pending</p>
        <p class="text-2xl font-bold">{{ $stats['total_task_pending'] }}</p>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('wm.users.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">
        + Tambah User Baru
    </a>
</div>
@endsection
