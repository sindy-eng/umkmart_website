@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('subtitle', 'Semua riwayat penjualan')

@push('header-actions')
<div class="flex items-center gap-2">
    <a href="{{ route('reports.pdf') }}" target="_blank"
       class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs font-semibold transition">
        PDF
    </a>
    <a href="{{ route('reports.excel') }}"
       class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-semibold transition">
        Excel
    </a>
</div>
@endpush

@section('content')
<div class="space-y-5">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-48">
                <label class="text-xs font-semibold text-gray-500 block mb-1.5">Cari No. Transaksi</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="TRX-0048..." class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 block mb-1.5">Status</label>
                <select name="status" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 bg-white">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                    <option value="batal"   {{ request('status')=='batal'?'selected':'' }}>Batal</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 block mb-1.5">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500 block mb-1.5">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Filter</button>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm font-medium transition">Reset</a>
        </form>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-orange-500">{{ $transactions->total() }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Transaksi</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-teal-600">{{ $totalSelesai }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Selesai</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-base font-black text-green-600 leading-tight">Rp {{ number_format($totalOmzetKeseluruhan, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Omzet{{ request('tanggal_mulai') || request('tanggal_selesai') ? ' (Filter)' : '' }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm text-center">
            <p class="text-2xl font-black text-red-500">{{ $totalDibatalkan }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Dibatalkan</p>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">No. Transaksi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Pelanggan</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Kasir</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Metode</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Total</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-orange-50/20 transition-colors">

                        {{-- No. Transaksi dipersingkat --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            @php
                                preg_match('/(\d+)$/', $trx->nomor_transaksi, $m);
                                $short = isset($m[1]) ? 'TRX-' . str_pad($m[1], 4, '0', STR_PAD_LEFT) : $trx->nomor_transaksi;
                            @endphp
                            <span class="text-sm font-mono font-bold text-teal-600">{{ $short }}</span>
                        </td>

                        {{-- Pelanggan --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="text-sm text-gray-700">{{ $trx->customer?->nama ?? 'Pelanggan Umum' }}</span>
                        </td>

                        {{-- Kasir --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="text-sm text-gray-500">{{ $trx->user?->name ?? '-' }}</span>
                        </td>

                        {{-- Metode Pembayaran --}}
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            @php
                                $metode = strtolower($trx->metode_bayar ?? 'tunai');
                                [$mClass, $mLabel] = match($metode) {
                                    'transfer' => ['bg-blue-100 text-blue-700',   'Transfer'],
                                    'qris'     => ['bg-purple-100 text-purple-700', 'QRIS'],
                                    default    => ['bg-green-100 text-green-700',  'Tunai'],
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $mClass }}">{{ $mLabel }}</span>
                        </td>

                        {{-- Total --}}
                        <td class="px-4 py-3.5 text-right whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-800">Rp {{ number_format($trx->total, 0, ',', '.') }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                {{ $trx->status === 'selesai' ? 'bg-green-100 text-green-700' : ($trx->status === 'batal' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-4 py-3.5 whitespace-nowrap">
                            <span class="text-sm text-gray-500">{{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                {{-- Detail --}}
                                <a href="{{ route('transactions.show', $trx) }}"
                                   class="p-1.5 text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                {{-- Struk --}}
                                <a href="{{ route('transactions.struk', $trx) }}"
                                   class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Struk">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </a>
                                {{-- Batalkan --}}
                                @if($trx->status !== 'batal')
                                <form method="POST" action="{{ route('transactions.destroy', $trx) }}"
                                      onsubmit="return confirm('Batalkan transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition" title="Batalkan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p class="text-sm">Belum ada transaksi ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($transactions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transactions->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection