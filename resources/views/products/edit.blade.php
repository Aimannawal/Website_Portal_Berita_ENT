@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="px-5 py-8 lg:px-8">
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-[.18em] text-[#6d94d3]">Product catalogue</p>
        <h1 class="mt-1 text-2xl font-bold text-[#182338]">Edit Product</h1>
    </div>

    <form id="product-form" action="{{ route('pk.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="portal-card max-w-2xl space-y-5 p-6">
        @csrf
        @method('PUT')
        <div>
            <label for="title" class="mb-1 block text-sm font-semibold text-[#182338]">Nama Product</label>
            <input id="title" type="text" name="title" value="{{ old('title', $product->title) }}" class="portal-input" required>
        </div>
        <div>
            <label for="description" class="mb-1 block text-sm font-semibold text-[#182338]">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="portal-input">{{ old('description', $product->description) }}</textarea>
        </div>
        <div>
            <label for="link" class="mb-1 block text-sm font-semibold text-[#182338]">Link Product</label>
            <input id="link" type="url" name="link" value="{{ old('link', $product->link) }}" class="portal-input" required>
        </div>
        @if ($product->thumbnail)
            <div>
                <p class="mb-2 text-sm font-semibold text-[#182338]">Thumbnail Saat Ini</p>
                <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="h-32 w-48 rounded-xl object-cover">
            </div>
        @endif
        <div>
            <label for="thumbnail" class="mb-1 block text-sm font-semibold text-[#182338]">Ganti Thumbnail</label>
            <input id="thumbnail" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="portal-input">
            <p class="mt-1 text-xs text-[#64748b]">Kosongkan jika tidak ingin mengganti. Maksimal 10 MB.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="portal-button portal-button-accent" type="submit">Update Product</button>
            <a href="{{ route('pk.products.index') }}" class="text-sm font-semibold text-[#64748b] hover:text-[#182338]">Batal</a>
        </div>
    </form>
</div>
@endsection
