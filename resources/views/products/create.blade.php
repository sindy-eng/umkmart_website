@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('subtitle', 'Tambahkan produk baru ke katalog')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <a href="{{ route('products.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h3 class="font-bold text-gray-800">Tambah Produk Baru</h3>
                <p class="text-xs text-gray-400">Lengkapi informasi produk di bawah ini</p>
            </div>
        </div>
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required placeholder="contoh: Kopi Arabica 250g"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nama_produk') border-red-400 @enderror">
                    @error('nama_produk')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" required list="kategoriList" placeholder="Pilih atau ketik kategori"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('kategori') border-red-400 @enderror">
                    <datalist id="kategoriList">
                        @foreach($kategoris as $kat)<option value="{{ $kat }}">@endforeach
                    </datalist>
                    @error('kategori')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga') }}" required min="0" step="500" placeholder="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('harga') border-red-400 @enderror">
                    @error('harga')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0" placeholder="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('stok') border-red-400 @enderror">
                    @error('stok')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Deskripsi produk (opsional)"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Foto Produk</label>
                    <input type="file" name="gambar_produk" accept="image/*"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, WebP. Maks 2MB</p>
                    @error('gambar_produk')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('products.index') }}" class="flex-1 text-center py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>
@endsection
