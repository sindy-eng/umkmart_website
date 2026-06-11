@extends('layouts.app')

@section('title', 'Struk Transaksi')
@section('subtitle', $transaction->nomor_transaksi)

@section('content')
<div class="max-w-md mx-auto space-y-4">
    {{-- Sukses Banner --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p class="text-sm font-semibold text-green-700">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Struk --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" id="struk">
        {{-- Header Struk --}}
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 text-center text-white">
            <h1 style="font-size: 24px; font-weight: 900; color: #1f2937;">
                UMK<span style="color: #ea580c;">MART</span>
            </h1>
            <p class="text-orange-100 text-xs mt-0.5">Sistem Manajemen UMKM</p>
            <div class="mt-3 bg-white/20 rounded-xl px-4 py-2 inline-block">
                <p class="text-sm font-mono font-bold">{{ $transaction->nomor_transaksi }}</p>
            </div>
        </div>

        <div class="p-5 space-y-4">
            {{-- Info Transaksi --}}
            <div class="grid grid-cols-2 gap-2 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Tanggal</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Kasir</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->user?->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Pelanggan</p>
                    <p class="font-semibold text-gray-800">{{ $transaction->customer?->nama ?? 'Umum' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Metode Bayar</p>
                    @php
                        $metodeBadge = match($transaction->metode_bayar ?? 'tunai') {
                            'tunai'    => ['bg-green-100 text-green-700', '💵 Tunai'],
                            'transfer' => ['bg-blue-100 text-blue-700',   '🏦 Transfer'],
                            'qris'     => ['bg-purple-100 text-purple-700','📱 QRIS'],
                            default    => ['bg-gray-100 text-gray-700',    ucfirst($transaction->metode_bayar ?? 'tunai')],
                        };
                    @endphp
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-bold {{ $metodeBadge[0] }}">
                        {{ $metodeBadge[1] }}
                    </span>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-400 text-xs">Status</p>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-bold {{ $transaction->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>

            <hr class="border-dashed border-gray-200">

            {{-- Item List --}}
            <div class="space-y-2">
                @foreach($transaction->details as $detail)
                <div class="flex items-center justify-between text-sm">
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800 truncate">{{ $detail->product?->nama_produk ?? 'Produk dihapus' }}</p>
                        <p class="text-gray-400 text-xs">{{ $detail->jumlah }} × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold text-gray-800 ml-3">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            <hr class="border-dashed border-gray-200">

            {{-- Ringkasan --}}
            <div class="space-y-2 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($transaction->diskon > 0)
                <div class="flex justify-between text-gray-500">
                    <span>Diskon {{ $transaction->promo?->nama_promo }}</span>
                    <span class="text-red-500">- Rp {{ number_format($transaction->diskon, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between font-black text-base text-gray-800 pt-2 border-t border-gray-100">
                    <span>Total</span>
                    <span class="text-teal-600">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Bayar</span>
                    <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-green-600">
                    <span>Kembalian</span>
                    <span>Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($transaction->customer)
            <div class="bg-amber-50 rounded-xl p-3 flex items-center justify-between">
                <span class="text-xs text-amber-700 font-medium">⭐ Poin loyalty diperoleh</span>
                <span class="text-sm font-bold text-amber-600">+{{ (int)($transaction->total / 10000) }} poin</span>
            </div>
            @endif

            <p class="text-center text-xs text-gray-400 pt-2">Terima kasih telah berbelanja!</p>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3">
        <button onclick="window.print()"
            class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Struk
        </button>
        <a href="{{ route('pos') }}"
            class="flex-1 py-3 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-bold text-center hover:shadow-lg transition flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            Transaksi Baru
        </a>
    </div>
</div>
@endsection