@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="px-5 py-8 lg:px-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">Product catalogue</p>
            <h1 class="mt-1 text-2xl font-bold text-[#182338]">Products</h1>
        </div>
        <a href="{{ route('pk.products.create') }}" class="portal-button portal-button-accent">+ Product Baru</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-[#dce6f5] bg-white shadow-[0_10px_30px_rgba(72,103,156,.08)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-left text-sm">
                <thead class="bg-[#f5f8fd] text-xs uppercase tracking-wide text-[#64748b]">
                    <tr>
                        <th class="p-4">Product</th>
                        <th class="p-4">Slug</th>
                        <th class="p-4">Deskripsi</th>
                        <th class="p-4">Link</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#dce6f5]">
                    @forelse ($products as $product)
                        <tr>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if ($product->thumbnail)
                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="h-14 w-20 rounded-lg object-cover">
                                    @else
                                        <div class="grid h-14 w-20 place-items-center rounded-lg bg-[#eaf1fc] text-xs font-bold text-[#6d94d3]">NO IMAGE</div>
                                    @endif
                                    <span class="font-semibold text-[#182338]">{{ $product->title }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-xs text-[#64748b]">{{ $product->slug }}</td>
                            <td class="max-w-xs p-4 text-[#64748b]">{{ \Illuminate\Support\Str::limit($product->description, 80) ?: '-' }}</td>
                            <td class="p-4"><a href="{{ $product->link }}" target="_blank" rel="noopener" class="font-semibold text-[#6d94d3] hover:underline">Buka link</a></td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('pk.products.edit', $product) }}" class="font-semibold text-[#6d94d3] hover:underline">Edit</a>
                                    <form action="{{ route('pk.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus product ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-semibold text-[#c75a5a] hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-sm text-[#64748b]">Belum ada product.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
