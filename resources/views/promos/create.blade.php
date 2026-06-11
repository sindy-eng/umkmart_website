@extends('layouts.app')

@section('title', 'Buat Promo')
@section('subtitle', 'Tambahkan program promosi baru')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <a href="{{ route('promos.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h3 class="font-bold text-gray-800">Buat Promo Baru</h3>
        </div>
        <form method="POST" action="{{ route('promos.store') }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nama Promo <span class="text-red-500">*</span></label>
                <input type="text" name="nama_promo" value="{{ old('nama_promo') }}" required placeholder="contoh: Flash Sale Akhir Bulan"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nama_promo') border-red-400 @enderror">
                @error('nama_promo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Tipe Diskon <span class="text-red-500">*</span></label>
                    <select name="tipe_diskon" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                        <option value="persen" {{ old('tipe_diskon') == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                        <option value="nominal" {{ old('tipe_diskon') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nilai Diskon <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai_diskon" value="{{ old('nilai_diskon') }}" required min="0" placeholder="0"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nilai_diskon') border-red-400 @enderror">
                    @error('nilai_diskon')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @error('tanggal_mulai')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 block mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @error('tanggal_selesai')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Syarat dan ketentuan promo (opsional)"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('promos.index') }}" class="flex-1 text-center py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Buat Promo</button>
            </div>
        </form>
    </div>
</div>
@endsection
