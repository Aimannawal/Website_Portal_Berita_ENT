@extends('layouts.app')
@section('title', 'Assign Task')

@section('content')
<h1 class="text-2xl font-bold mb-6">Assign Task ke Divisi</h1>

<form action="{{ route('pk.tasks.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul Task</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Divisi Tujuan</label>
        <select name="assigned_to_division" class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Divisi --</option>
            @foreach ($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('assigned_to_division') == $division->id)>
                    {{ $division->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Terkait Berita (opsional)</label>
        <select name="berita_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Tidak ada --</option>
            @foreach ($berita as $item)
                <option value="{{ $item->id }}" @selected(old('berita_id') == $item->id)>{{ $item->title }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Terkait Artikel (opsional)</label>
        <select name="artikel_id" class="w-full border rounded px-3 py-2">
            <option value="">-- Tidak ada --</option>
            @foreach ($artikel as $item)
                <option value="{{ $item->id }}" @selected(old('artikel_id') == $item->id)>{{ $item->title }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Deadline</label>
        <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full border rounded px-3 py-2">
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Assign Task</button>
    <a href="{{ route('pk.tasks.index') }}" class="text-sm underline ml-2">Batal</a>
</form>
@endsection
