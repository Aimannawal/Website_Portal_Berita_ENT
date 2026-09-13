@extends('layouts.app')
@section('title', 'Detail Task')

@section('content')
<h1 class="text-2xl font-bold mb-6">{{ $task->title }}</h1>

<div class="bg-white p-6 rounded shadow max-w-lg space-y-3 text-sm">
    <p><span class="font-medium">Deskripsi:</span> {{ $task->description ?? '-' }}</p>
    <p><span class="font-medium">Divisi Tujuan:</span> {{ $task->division?->name }}</p>
    <p><span class="font-medium">Ditugaskan ke:</span> {{ $task->assignedUser?->name ?? 'Belum ditentukan orangnya' }}</p>
    <p><span class="font-medium">Di-assign oleh:</span> {{ $task->assignedBy?->name }}</p>
    <p><span class="font-medium">Konten terkait:</span> {{ $task->berita?->title ?? $task->artikel?->title ?? '-' }}</p>
    <p><span class="font-medium">Deadline:</span> {{ $task->deadline?->format('d M Y') ?? '-' }}</p>
    <p><span class="font-medium">Status:</span> {{ $task->status }}</p>
    <p><span class="font-medium">Catatan dari divisi:</span> {{ $task->notes ?? '-' }}</p>
</div>

<a href="{{ route('pk.tasks.index') }}" class="inline-block mt-4 text-sm underline">← Kembali</a>
@endsection
