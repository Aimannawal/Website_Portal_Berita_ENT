@extends('layouts.app')
@section('title', 'Task Saya')

@section('content')
<h1 class="text-2xl font-bold mb-6">Task Saya</h1>

<div class="space-y-3">
    @forelse ($tasks as $task)
        <div class="bg-white p-4 rounded shadow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold">{{ $task->title }}</p>
                    <p class="text-sm text-gray-500">{{ $task->description }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Deadline: {{ $task->deadline?->format('d M Y') ?? '-' }}
                        — Konten: {{ $task->berita?->title ?? $task->artikel?->title ?? '-' }}
                    </p>
                </div>
                <span class="px-2 py-1 rounded text-xs shrink-0
                    @class([
                        'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                        'bg-blue-100 text-blue-700' => $task->status === 'in_progress',
                        'bg-green-100 text-green-700' => $task->status === 'done',
                    ])">
                    {{ $task->status }}
                </span>
            </div>

            @if ($task->status !== 'done')
                <form action="{{ route('divisi.tasks.update-status', $task) }}" method="POST" class="mt-3 flex gap-2 items-center">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="border rounded px-2 py-1 text-sm">
                        <option value="in_progress" @selected($task->status === 'in_progress')>Sedang Dikerjakan</option>
                        <option value="done">Selesai</option>
                    </select>
                    <input type="text" name="notes" placeholder="Catatan (opsional)" class="border rounded px-2 py-1 text-sm flex-1">
                    <button class="bg-gray-900 text-white px-3 py-1 rounded text-sm">Update</button>
                </form>
            @endif
        </div>
    @empty
        <p class="text-sm text-gray-500">Belum ada task untukmu.</p>
    @endforelse
</div>

<div class="mt-4">{{ $tasks->links() }}</div>
@endsection
