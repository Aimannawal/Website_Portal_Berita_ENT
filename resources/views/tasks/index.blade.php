@extends('layouts.app')
@section('title', 'Kelola Task')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Kelola Task</h1>
    <a href="{{ route('pk.tasks.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Assign Task</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Judul</th>
                <th class="p-3">Divisi Tujuan</th>
                <th class="p-3">Konten Terkait</th>
                <th class="p-3">Deadline</th>
                <th class="p-3">Status</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach ($tasks as $task)
                <tr>
                    <td class="p-3">{{ $task->title }}</td>
                    <td class="p-3">{{ $task->division?->name }}</td>
                    <td class="p-3">{{ $task->berita?->title ?? $task->artikel?->title ?? '-' }}</td>
                    <td class="p-3">{{ $task->deadline?->format('d M Y') ?? '-' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs
                            @class([
                                'bg-yellow-100 text-yellow-700' => $task->status === 'pending',
                                'bg-blue-100 text-blue-700' => $task->status === 'in_progress',
                                'bg-green-100 text-green-700' => $task->status === 'done',
                                'bg-red-100 text-red-700' => $task->status === 'rejected',
                            ])">
                            {{ $task->status }}
                        </span>
                    </td>
                    <td class="p-3">
                        <a href="{{ route('pk.tasks.show', $task) }}" class="text-blue-600 hover:underline">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $tasks->links() }}</div>
@endsection
