@extends('layouts.app')

@section('title', 'Pengeluaran')
@section('subtitle', 'Catat dan kelola biaya operasional')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex flex-wrap gap-2 items-center flex-1">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari keterangan..." class="pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 bg-white">
            </div>
            <select name="kategori" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <input type="month" name="bulan" value="{{ request('bulan', now()->format('Y-m')) }}" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">Filter</button>
            <a href="{{ route('expenses.index') }}" class="px-3 py-2.5 text-sm text-gray-500 hover:text-gray-700 transition">Reset</a>
        </form>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 text-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengeluaran
        </button>
    </div>

    {{-- Info Bulan Ini --}}
    <div class="bg-gradient-to-br from-red-50 to-rose-50 rounded-2xl p-5 border border-red-100 flex items-center justify-between">
        <div>
            <p class="text-xs font-semibold text-red-400 uppercase tracking-wider">Total Pengeluaran Bulan Ini</p>
            <p class="text-3xl font-black text-red-600 mt-1">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
            <p class="text-xs text-red-300 mt-0.5">{{ now()->format('F Y') }}</p>
        </div>
        <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
    </div>

    {{-- Tabel Pengeluaran --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Dicatat oleh</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($expenses as $expense)
                    <tr class="hover:bg-red-50/20 transition-colors">
                        <td class="px-5 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($expense->tanggal)->format('d M Y') }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex px-2.5 py-1 bg-teal-50 text-teal-700 rounded-lg text-xs font-medium">{{ $expense->kategori }}</span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $expense->keterangan ?: '-' }}</td>
                        <td class="px-5 py-4 text-right text-sm font-bold text-red-600">Rp {{ number_format($expense->jumlah, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $expense->user?->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Hapus pengeluaran ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p class="text-sm">Belum ada pengeluaran tercatat</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($expenses->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $expenses->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah Pengeluaran --}}
<div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Tambah Pengeluaran</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('expenses.store') }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <select name="kategori" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat }}">{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Jumlah (Rp) <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" min="0" step="500" required placeholder="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700 block mb-1.5">Keterangan</label>
                <textarea name="keterangan" rows="2" placeholder="Deskripsi pengeluaran..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
