@extends('layouts.app')

@section('title', 'Riwayat Pelanggan')
@section('subtitle', $customer->nama)

@section('content')
<div class="space-y-5">
    {{-- Info Pelanggan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col sm:flex-row gap-5 items-start">
        <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl flex items-center justify-center flex-shrink-0">
            <span class="text-3xl font-black text-white">{{ strtoupper(substr($customer->nama, 0, 1)) }}</span>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-black text-gray-800">{{ $customer->nama }}</h2>
            @if($customer->nomor_wa)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->nomor_wa) }}" target="_blank" class="text-sm text-green-600 hover:underline">{{ $customer->nomor_wa }}</a>
            @endif
            @if($customer->alamat)<p class="text-sm text-gray-400 mt-0.5">{{ $customer->alamat }}</p>@endif
        </div>
        <div class="flex items-center gap-4 text-center">
            <div>
                <p class="text-2xl font-black text-teal-600">{{ $transactions->total() }}</p>
                <p class="text-xs text-gray-400">Transaksi</p>
            </div>
            <div class="w-px h-8 bg-gray-200"></div>
            <div>
                <p class="text-2xl font-black text-amber-500">⭐ {{ $customer->total_poin }}</p>
                <p class="text-xs text-gray-400">Poin</p>
            </div>
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Riwayat Transaksi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">No. Transaksi</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-teal-50/20">
                        <td class="px-5 py-3 text-sm font-mono font-bold text-teal-600">{{ $trx->nomor_transaksi }}</td>
                        <td class="px-5 py-3 text-sm text-right font-bold text-gray-800">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $trx->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($trx->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-gray-400">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">{{ $transactions->links() }}</div>
        @endif
    </div>
</div>
@endsection
