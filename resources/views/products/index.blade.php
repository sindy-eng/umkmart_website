@extends('layouts.app')

@section('title', 'Manajemen Produk')
@section('subtitle', 'Kelola stok dan katalog produk')

@section('content')
<div class="space-y-5">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <div class="flex gap-2 w-full sm:w-auto">
            <form method="GET" class="flex gap-2 flex-1 sm:flex-none">
                <div class="relative flex-1 sm:w-72">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
                <select name="kategori" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">Filter</button>
            </form>
        </div>
        @if(auth()->user()->role === 'admin')
        <button onclick="document.getElementById('modalTambahProduk').classList.remove('hidden')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 text-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </button>
        @endif
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-3 gap-3">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-gray-800">{{ $products->total() }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Produk</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-teal-600">{{ $kategoris->count() }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Kategori</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-red-500">{{ \App\Models\Product::stokMenipis()->count() }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Stok Menipis</p>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        @if(auth()->user()->role === 'admin')
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-orange-50/20 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center"
                                     style="{{ $product->gambar_produk ? 'background:#fff' : 'background:linear-gradient(135deg,#fed7aa,#fb923c)' }}">
                                    @if($product->gambar_produk)
                                    <img src="{{ asset(Storage::url($product->gambar_produk)) }}"
                                         class="w-full h-full object-cover"
                                         alt="{{ $product->nama_produk }}"
                                         onerror="this.parentElement.innerHTML='<span style=\'font-size:1.5rem\'>🛒</span>'">
                                    @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $product->nama_produk }}</p>
                                    @if($product->deskripsi)
                                    <p class="text-xs text-gray-400 truncate max-w-xs">{{ $product->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex px-2.5 py-1 bg-orange-50 text-orange-700 rounded-lg text-xs font-medium">{{ $product->kategori }}</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <span class="text-sm font-bold text-gray-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="text-sm font-bold px-2.5 py-1 rounded-lg
                                {{ $product->stok == 0 ? 'bg-red-100 text-red-700' : ($product->stok < 10 ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') }}">
                                {{ $product->stok }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        @if(auth()->user()->role === 'admin')
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-sm">Belum ada produk.
                                @if(auth()->user()->role === 'admin')
                                <button onclick="document.getElementById('modalTambahProduk').classList.remove('hidden')" class="text-orange-600 font-semibold hover:underline">Tambah sekarang</button>
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $products->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

{{-- =================== MODAL TAMBAH PRODUK (Admin Only) =================== --}}
@if(auth()->user()->role === 'admin')
<div id="modalTambahProduk" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 sticky top-0 bg-white z-10">
            <div>
                <h3 class="font-bold text-gray-800">Tambah Produk Baru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Lengkapi informasi produk di bawah ini</p>
            </div>
            <button onclick="document.getElementById('modalTambahProduk').classList.add('hidden'); resetPreview()"
                class="p-2 hover:bg-gray-100 rounded-xl transition text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf

            {{-- Preview Gambar --}}
            <div class="flex flex-col items-center gap-3">
                <div id="previewContainer"
                     class="w-32 h-32 rounded-2xl overflow-hidden flex items-center justify-center border-2 border-dashed border-orange-300 bg-orange-50 cursor-pointer relative group"
                     onclick="document.getElementById('gambarProdukInput').click()">
                    <img id="previewImg" src="" alt="" class="hidden w-full h-full object-cover absolute inset-0">
                    <div id="previewPlaceholder" class="flex flex-col items-center gap-2 text-orange-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs font-medium">Klik untuk upload</span>
                    </div>
                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <input id="gambarProdukInput" type="file" name="gambar_produk" accept="image/*" class="hidden" onchange="previewImage(this)">
                <p class="text-xs text-gray-400">Format: JPG, PNG, WebP. Maks 2MB</p>
                @error('gambar_produk')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Form Fields --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required placeholder="contoh: Beras Premium 5kg"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nama_produk') border-red-400 @enderror">
                    @error('nama_produk')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" required list="kategoriListModal" placeholder="Pilih atau ketik kategori"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('kategori') border-red-400 @enderror">
                    <datalist id="kategoriListModal">
                        @foreach($kategoris as $kat)<option value="{{ $kat }}">@endforeach
                        <option value="Beras & Sembako">
                        <option value="Minyak & Lemak">
                        <option value="Bumbu Dapur">
                        <option value="Minuman">
                        <option value="Kebersihan">
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
                    <textarea name="deskripsi" rows="2" placeholder="Deskripsi produk (opsional)"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modalTambahProduk').classList.add('hidden'); resetPreview()"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const img = document.getElementById('previewImg');
    const placeholder = document.getElementById('previewPlaceholder');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        // Max 2MB check
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'warning', title: 'File Terlalu Besar', text: 'Ukuran gambar maksimal 2MB', confirmButtonColor: '#f97316' });
            input.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function resetPreview() {
    const img = document.getElementById('previewImg');
    const placeholder = document.getElementById('previewPlaceholder');
    const input = document.getElementById('gambarProdukInput');
    if (img) {
        img.src = '';
        img.classList.add('hidden');
    }
    if (placeholder) placeholder.classList.remove('hidden');
    if (input) input.value = '';
}

// Buka modal jika ada error validasi (setelah redirect)
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modalTambahProduk').classList.remove('hidden');
    });
@endif
</script>
@endpush
