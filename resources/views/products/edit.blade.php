@extends('layouts.app')

@section('title', 'Edit Produk')
@section('subtitle', 'Perbarui informasi produk')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <a href="{{ route('products.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h3 class="font-bold text-gray-800">Edit Produk</h3>
                <p class="text-xs text-gray-400">{{ $product->nama_produk }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nama_produk') border-red-400 @enderror">
                    @error('nama_produk')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="kategori" value="{{ old('kategori', $product->kategori) }}" required list="kategoriList"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('kategori') border-red-400 @enderror">
                    <datalist id="kategoriList">
                        @foreach($kategoris as $kat)<option value="{{ $kat }}">@endforeach
                    </datalist>
                    @error('kategori')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0" step="500"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('harga') border-red-400 @enderror">
                    @error('harga')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" required min="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('stok') border-red-400 @enderror">
                    @error('stok')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Foto Produk</label>
                    @if($product->gambar_produk)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ Storage::url($product->gambar_produk) }}" class="w-16 h-16 rounded-xl object-cover border border-gray-200" alt="">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Foto saat ini</p>
                            <button type="button"
                                onclick="hapusFoto('{{ route('products.delete-image', $product) }}')"
                                class="text-xs text-red-500 hover:text-red-700 font-medium">
                                Hapus foto
                            </button>
                            <script>
                            function hapusFoto(url) {
                                if (!confirm('Hapus foto ini?')) return;
                                fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]') ? document.querySelector('meta[name=csrf-token]').content : '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                }).then(r => {
                                    if (r.ok || r.redirected) { window.location.reload(); }
                                    else { alert('Gagal menghapus foto!'); }
                                }).catch(() => window.location.reload());
                            }
                            </script>
                        </div>
                    </div>
                    @endif
                    <input type="file" name="gambar_produk" accept="image/*"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                    @error('gambar_produk')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1" {{ old('aktif', $product->aktif) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                        <span class="text-sm font-semibold text-gray-700">Produk Aktif (ditampilkan di POS)</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('products.index') }}" class="flex-1 text-center py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection