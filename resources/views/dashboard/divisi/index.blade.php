@extends('layouts.app')
@section('title', 'Dashboard Saya')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard — {{ auth()->user()->division?->name }}</h1>

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $summary['pending'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Diproses</p>
        <p class="text-2xl font-bold text-blue-600">{{ $summary['in_progress'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Selesai</p>
        <p class="text-2xl font-bold text-green-600">{{ $summary['done'] }}</p>
    </div>
</div>

<h2 class="text-lg font-semibold mb-3">Task Terbaru Saya</h2>
<div class="bg-white rounded shadow divide-y">
    @forelse ($tasks as $task)
        <div class="p-3 flex justify-between items-center text-sm">
            <div>
                <p class="font-medium">{{ $task->title }}</p>
                <p class="text-gray-500">Deadline: {{ $task->deadline?->format('d M Y') ?? '-' }}</p>
            </div>
            <span class="px-2 py-1 rounded text-xs
                @class([
                    'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                    'bg-blue-100 text-blue-700' => $task->status === 'in_progress',
                    'bg-green-100 text-green-700' => $task->status === 'done',
                ])">
                {{ $task->status }}
            </span>
        </div>
    @empty
        <p class="p-3 text-sm text-gray-500">Belum ada task untukmu.</p>
    @endforelse
</div>

<a href="{{ route('divisi.tasks.index') }}" class="inline-block mt-4 text-sm underline">Lihat semua task saya →</a>
@endsection
