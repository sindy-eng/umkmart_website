@extends('layouts.app')

@section('title', 'Edit Pengeluaran')
@section('subtitle', 'Perbarui data pengeluaran')

@section('content')
<div class="max-w-lg">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <a href="{{ route('expenses.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h3 class="font-bold text-gray-800">Edit Pengeluaran</h3>
        </div>
        <form method="POST" action="{{ route('expenses.update', $expense) }}" class="p-6 space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', $expense->tanggal) }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat }}" {{ old('kategori', $expense->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Jumlah (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $expense->jumlah) }}" required min="0" step="500"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('keterangan', $expense->keterangan) }}</textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="{{ route('expenses.index') }}" class="flex-1 text-center py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
