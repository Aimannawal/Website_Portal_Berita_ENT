@extends('layouts.app')
@section('title', 'Kelola Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold">Kelola Pelanggan</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar email yang berlangganan newsletter NewsHub.</p>
    </div>
    <a href="{{ route('wm.subscribers.export') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">
        Ekspor CSV
    </a>
</div>

@if (session('success'))
    <div class="mb-4 rounded bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('success') }}</div>
@endif

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Email</th>
                <th class="p-3">Berlangganan Sejak</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($subscribers as $subscriber)
                <tr>
                    <td class="p-3 text-gray-400">{{ $subscribers->firstItem() + $loop->index }}</td>
                    <td class="p-3 font-medium">{{ $subscriber->email }}</td>
                    <td class="p-3">{{ $subscriber->subscribed_at?->format('d M Y, H:i') }}</td>
                    <td class="p-3">
                        <form action="{{ route('wm.subscribers.destroy', $subscriber) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus pelanggan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-400">Belum ada pelanggan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $subscribers->links() }}</div>
@endsection
