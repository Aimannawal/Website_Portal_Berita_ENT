@extends('layouts.app')
@section('title', 'Dashboard Perencanaan Konten')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Perencanaan Konten</h1>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
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
        <p class="text-2xl font-bold text-yellow-600">{{ $stats['task_pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Task Diproses</p>
        <p class="text-2xl font-bold text-blue-600">{{ $stats['task_progress'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Task Selesai</p>
        <p class="text-2xl font-bold text-green-600">{{ $stats['task_done'] }}</p>
    </div>
</div>

<div class="flex gap-3 mb-8">
    <a href="{{ route('pk.berita.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Berita Baru</a>
    <a href="{{ route('pk.artikel.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Artikel Baru</a>
    <a href="{{ route('pk.tasks.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Assign Task</a>
</div>

<h2 class="text-lg font-semibold mb-3">Task Terbaru</h2>
<div class="bg-white rounded shadow divide-y">
    @forelse ($recentTasks as $task)
        <div class="p-3 flex justify-between items-center text-sm">
            <div>
                <p class="font-medium">{{ $task->title }}</p>
                <p class="text-gray-500">Divisi: {{ $task->division?->name }} — {{ $task->assignedUser?->name ?? 'Belum ditentukan orangnya' }}</p>
            </div>
            <span class="px-2 py-1 rounded text-xs
                @class([
                    'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                    'bg-blue-100 text-blue-700' => $task->status === 'in_progress',
                    'bg-green-100 text-green-700' => $task->status === 'done',
                    'bg-red-100 text-red-700' => $task->status === 'rejected',
                ])">
                {{ $task->status }}
            </span>
        </div>
    @empty
        <p class="p-3 text-sm text-gray-500">Belum ada task.</p>
    @endforelse
</div>
@endsection
