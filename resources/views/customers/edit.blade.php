@extends('layouts.app')

@section('title', 'Edit Pelanggan')
@section('subtitle', 'Perbarui data pelanggan')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <a href="{{ route('customers.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h3 class="font-bold text-gray-800">Edit Pelanggan: {{ $customer->nama }}</h3>
        </div>
        <form method="POST" action="{{ route('customers.update', $customer) }}" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 @error('nama') border-red-400 @enderror">
                @error('nama')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Nomor WhatsApp</label>
                <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $customer->nomor_wa) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('alamat', $customer->alamat) }}</textarea>
            </div>
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $customer->aktif) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    <span class="text-sm font-semibold text-gray-700">Pelanggan Aktif</span>
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('customers.index') }}" class="flex-1 text-center py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
