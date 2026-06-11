@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('subtitle', $transaction->nomor_transaksi)

@push('header-actions')
<div class="flex items-center gap-2">
    <a href="{{ route('transactions.struk', $transaction) }}" target="_blank"
       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white rounded-lg text-xs font-semibold hover:shadow-md transition">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Print Struk
    </a>
</div>
@endpush

@section('content')
<div class="space-y-5 max-w-5xl mx-auto">

    {{-- ── Header Card ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Gradient bar top --}}
        <div class="h-1.5 bg-gradient-to-r from-amber-400 via-orange-500 to-orange-600"></div>

        <div class="px-6 py-5 flex flex-col sm:flex-row sm:items-center gap-4">
            {{-- Kembali --}}
            <a href="{{ route('transactions.index') }}"
               class="inline-flex items-center gap-1.5 text-gray-500 hover:text-orange-600 text-sm font-medium transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>

            <div class="flex-1 min-w-0">
                {{-- Nomor + Badge Status --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl sm:text-2xl font-black text-gray-800 font-mono tracking-tight">
                        {{ $transaction->nomor_transaksi }}
                    </h2>
                    @php
                        [$sBg, $sLabel] = match($transaction->status) {
                            'selesai'   => ['bg-green-100 text-green-700 ring-green-200',   'Selesai'],
                            'batal'     => ['bg-red-100 text-red-700 ring-red-200',         'Dibatalkan'],
                            'dibatalkan'=> ['bg-red-100 text-red-700 ring-red-200',         'Dibatalkan'],
                            default     => ['bg-yellow-100 text-yellow-700 ring-yellow-200','Pending'],
                        };
                    @endphp
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold ring-1 {{ $sBg }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $transaction->status === 'selesai' ? 'bg-green-500' : ($transaction->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                        {{ $sLabel }}
                    </span>
                </div>
                {{-- Tanggal --}}
                <p class="text-sm text-gray-400 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $transaction->created_at->format('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>
    </div>

    {{-- ── 2-Column Info ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Kolom Kiri: Info Transaksi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1 h-4 bg-orange-500 rounded-full"></span>
                Info Transaksi
            </h3>

            {{-- Pelanggan --}}
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-teal-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Pelanggan</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">
                        {{ $transaction->customer->nama ?? 'Pelanggan Umum' }}
                    </p>
                    @if($transaction->customer?->no_wa)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $transaction->customer->no_wa) }}" target="_blank"
                       class="text-xs text-teal-600 hover:underline">
                        {{ $transaction->customer->no_wa }}
                    </a>
                    @endif
                </div>
            </div>

            {{-- Kasir --}}
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Kasir</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">
                        {{ $transaction->user?->name ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Metode Bayar --}}
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Metode Bayar</p>
                    <div class="mt-1">
                        @php
                            $metode = strtolower($transaction->metode_bayar ?? 'tunai');
                            [$mClass, $mLabel] = match($metode) {
                                'transfer' => ['bg-blue-100 text-blue-700',   '🏦 Transfer'],
                                'qris'     => ['bg-purple-100 text-purple-700','📱 QRIS'],
                                default    => ['bg-green-100 text-green-700',  '💵 Tunai'],
                            };
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $mClass }}">
                            {{ $mLabel }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Promo --}}
            @if($transaction->promo)
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:18px;height:18px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Promo Dipakai</p>
                    <p class="text-sm font-semibold text-amber-600 mt-0.5">{{ $transaction->promo->nama_promo }}</p>
                </div>
            </div>
            @endif

            {{-- Catatan --}}
            @if($transaction->catatan)
            <div class="bg-gray-50 rounded-xl p-3">
                <p class="text-xs text-gray-400 font-medium mb-1">📝 Catatan</p>
                <p class="text-sm text-gray-700">{{ $transaction->catatan }}</p>
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Ringkasan Pembayaran --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1 h-4 bg-teal-500 rounded-full"></span>
                Ringkasan Pembayaran
            </h3>

            <div class="space-y-3">
                {{-- Subtotal --}}
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-semibold text-gray-800">
                        Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Diskon --}}
                @if($transaction->diskon > 0)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">
                        Diskon
                        @if($transaction->promo)
                            <span class="text-amber-500 text-xs">({{ $transaction->promo->nama_promo }})</span>
                        @endif
                    </span>
                    <span class="font-semibold text-red-500">
                        − Rp {{ number_format($transaction->diskon, 0, ',', '.') }}
                    </span>
                </div>
                @else
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Diskon</span>
                    <span class="text-gray-400">−</span>
                </div>
                @endif

                {{-- Divider --}}
                <div class="border-t border-dashed border-gray-200 my-1"></div>

                {{-- Total (highlighted) --}}
                <div class="bg-orange-50 rounded-xl px-4 py-3 flex items-center justify-between">
                    <span class="text-sm font-bold text-orange-700">TOTAL</span>
                    <span class="text-xl font-black text-orange-600">
                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Uang Bayar --}}
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Uang Bayar</span>
                    <span class="font-semibold text-gray-800">
                        Rp {{ number_format($transaction->bayar, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Kembalian --}}
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Kembalian</span>
                    <span class="font-bold text-teal-600 text-base">
                        Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Loyalty Points --}}
            @if($transaction->customer && $transaction->status === 'selesai')
            <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">⭐</span>
                    <span class="text-xs font-semibold text-amber-700">Poin Loyalty Diperoleh</span>
                </div>
                <span class="text-sm font-black text-amber-600">
                    +{{ (int)($transaction->total / 10000) }} poin
                </span>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Tabel Item Dibeli ── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest flex items-center gap-2">
                <span class="w-1 h-4 bg-blue-500 rounded-full"></span>
                Item yang Dibeli
            </h3>
            <span class="text-xs bg-gray-100 text-gray-500 font-semibold px-2.5 py-1 rounded-full">
                {{ $transaction->details->count() }} item
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="text-right px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Harga Satuan</th>
                        <th class="text-center px-4 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaction->details as $detail)
                    <tr class="hover:bg-orange-50/30 transition-colors">
                        {{-- Produk --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Gambar Produk --}}
                                @if($detail->product?->gambar)
                                <img src="{{ asset('storage/' . $detail->product->gambar) }}"
                                     alt="{{ $detail->product->nama_produk }}"
                                     class="w-10 h-10 rounded-xl object-cover border border-gray-100 shrink-0">
                                @else
                                <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ $detail->product?->nama_produk ?? 'Produk dihapus' }}
                                    </p>
                                    @if($detail->product?->kategori)
                                    <p class="text-xs text-gray-400">{{ $detail->product->kategori }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Harga Satuan --}}
                        <td class="px-4 py-4 text-right whitespace-nowrap">
                            <span class="text-sm text-gray-600">
                                Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Jumlah --}}
                        <td class="px-4 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-50 text-orange-600 rounded-lg text-sm font-bold">
                                {{ $detail->jumlah }}
                            </span>
                        </td>

                        {{-- Subtotal --}}
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-800">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 text-sm">
                            Tidak ada item ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                {{-- Footer total --}}
                <tfoot>
                    <tr class="bg-gray-50 border-t border-gray-200">
                        <td colspan="3" class="px-6 py-3.5 text-right text-sm font-bold text-gray-700">
                            Grand Total
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <span class="text-base font-black text-orange-600">
                                Rp {{ number_format($transaction->total, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ── Action Footer ── --}}
    <div class="flex flex-wrap gap-3 justify-between">
        <a href="{{ route('transactions.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Riwayat
        </a>
        <div class="flex gap-2">
            <a href="{{ route('transactions.struk', $transaction) }}" target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white rounded-xl text-sm font-bold hover:shadow-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Struk
            </a>
        </div>
    </div>

</div>
@endsection
