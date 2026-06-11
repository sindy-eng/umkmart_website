@extends('layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan operasional hari ini')

@section('content')
<div class="space-y-6">

    {{-- Statistik Kartu --}}
    <div class="grid grid-cols-2 {{ auth()->user()->role === 'admin' ? 'lg:grid-cols-5' : 'lg:grid-cols-3' }} gap-4">
        {{-- Penjualan Hari Ini --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow-sm flex flex-col gap-3 text-white"
             style="background: linear-gradient(135deg, #fb923c, #ea580c)">
            <div class="flex items-start justify-between">
                <span class="text-xs font-semibold text-orange-100 uppercase tracking-wider leading-tight">Penjualan<br>Hari Ini</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.2)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-white">{{ $penjualanHariIni }}</p>
                <p class="text-xs text-orange-100 mt-1">Transaksi selesai</p>
            </div>
            <div class="absolute w-20 h-20 rounded-full -bottom-4 -right-4" style="background:rgba(255,255,255,0.1)"></div>
        </div>

        {{-- Omzet Hari Ini --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow-sm flex flex-col gap-3 text-white"
             style="background: linear-gradient(135deg, #2dd4bf, #0d9488)">
            <div class="flex items-start justify-between">
                <span class="text-xs font-semibold text-teal-100 uppercase tracking-wider leading-tight">Omzet<br>Hari Ini</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.2)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <p class="text-xl font-black text-white leading-tight">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</p>
                <p class="text-xs text-teal-100 mt-1">Total pendapatan</p>
            </div>
            <div class="absolute w-20 h-20 rounded-full -bottom-4 -right-4" style="background:rgba(255,255,255,0.1)"></div>
        </div>

        @if(auth()->user()->role === 'admin')
        {{-- Total Produk --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow-sm flex flex-col gap-3 text-white"
             style="background: linear-gradient(135deg, #fbbf24, #d97706)">
            <div class="flex items-start justify-between">
                <span class="text-xs font-semibold text-amber-100 uppercase tracking-wider leading-tight">Total<br>Produk</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.2)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-white">{{ $totalProduk }}</p>
                <p class="text-xs text-amber-100 mt-1">Produk aktif</p>
            </div>
            <div class="absolute w-20 h-20 rounded-full -bottom-4 -right-4" style="background:rgba(255,255,255,0.1)"></div>
        </div>
        @endif

        {{-- Stok Menipis --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow-sm flex flex-col gap-3 text-white"
             style="background: linear-gradient(135deg, #f87171, #dc2626)">
            <div class="flex items-start justify-between">
                <span class="text-xs font-semibold text-red-100 uppercase tracking-wider leading-tight">Stok<br>Menipis</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.2)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-white">{{ $stokMenipis }}</p>
                <p class="text-xs text-red-100 mt-1">Perlu restock</p>
            </div>
            <div class="absolute w-20 h-20 rounded-full -bottom-4 -right-4" style="background:rgba(255,255,255,0.1)"></div>
        </div>

        @if(auth()->user()->role === 'admin')
        {{-- Total Pelanggan --}}
        <div class="relative overflow-hidden rounded-2xl p-5 shadow-sm flex flex-col gap-3 text-white"
             style="background: linear-gradient(135deg, #a78bfa, #7c3aed)">
            <div class="flex items-start justify-between">
                <span class="text-xs font-semibold text-violet-100 uppercase tracking-wider leading-tight">Total<br>Pelanggan</span>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(255,255,255,0.2)">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-white">{{ $totalPelanggan }}</p>
                <p class="text-xs text-violet-100 mt-1">Member terdaftar</p>
            </div>
            <div class="absolute w-20 h-20 rounded-full -bottom-4 -right-4" style="background:rgba(255,255,255,0.1)"></div>
        </div>
        @endif
    </div>

    @if(auth()->user()->role === 'admin')
    {{-- Grafik & Stok Menipis --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Grafik Penjualan 7 Hari --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Grafik Penjualan</h3>
                    <p class="text-xs text-gray-400">7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 text-xs text-gray-500"><span class="w-3 h-3 rounded-sm bg-teal-400 inline-block"></span>Omzet</span>
                </div>
            </div>
            <div id="chartPenjualan"></div>
        </div>

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Stok Menipis</h3>
                    <p class="text-xs text-gray-400">Perlu segera diisi</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @forelse($produkStokMenipis as $produk)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $produk->nama_produk }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $produk->stok <= 3 ? 'bg-red-500' : 'bg-amber-400' }}" style="width: {{ min(100, ($produk->stok / 10) * 100) }}%"></div>
                            </div>
                            <span class="text-xs font-bold {{ $produk->stok <= 3 ? 'text-red-600' : 'text-amber-600' }}">{{ $produk->stok }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm">Semua stok aman!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Produk Terlaris & Transaksi Terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Produk Terlaris --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Produk Terlaris</h3>
                    <p class="text-xs text-gray-400">Top 5 semua waktu</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($produkTerlaris as $i => $item)
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-black flex-shrink-0
                        {{ $i === 0 ? 'bg-amber-400 text-white' : ($i === 1 ? 'bg-gray-200 text-gray-600' : ($i === 2 ? 'bg-teal-100 text-teal-700' : 'bg-gray-100 text-gray-500')) }}">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product?->nama_produk ?? 'Produk dihapus' }}</p>
                        <p class="text-xs text-gray-400">{{ $item->total_terjual }} terjual</p>
                    </div>
                    <p class="text-sm font-bold text-teal-600">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</p>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <p class="text-sm">Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Transaksi Terbaru --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Transaksi Terbaru</h3>
                    <p class="text-xs text-gray-400">5 transaksi terakhir</p>
                </div>
                <a href="{{ route('transactions.index') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($transaksiTerbaru as $trx)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $trx->status === 'selesai' ? 'bg-green-100' : 'bg-red-100' }}">
                        <svg class="w-4 h-4 {{ $trx->status === 'selesai' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($trx->status === 'selesai')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $trx->nomor_transaksi }}</p>
                        <p class="text-xs text-gray-400">{{ $trx->customer?->nama ?? 'Pelanggan umum' }} · {{ $trx->created_at->format('d M H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800">Rp {{ number_format($trx->total, 0, ',', '.') }}</p>
                        <span class="text-xs px-1.5 py-0.5 rounded-full font-medium {{ $trx->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <p class="text-sm">Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'kasir')
    {{-- Kasir: Stok Menipis List + POS Shortcut --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-base font-bold text-gray-800">Stok Menipis</h3>
                    <p class="text-xs text-gray-400">Perlu segera diisi</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($produkStokMenipis as $produk)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-teal-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $produk->nama_produk }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $produk->stok <= 3 ? 'bg-red-500' : 'bg-amber-400' }}" style="width: {{ min(100, ($produk->stok / 10) * 100) }}%"></div>
                            </div>
                            <span class="text-xs font-bold {{ $produk->stok <= 3 ? 'text-red-600' : 'text-amber-600' }}">{{ $produk->stok }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm">Semua stok aman!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Kasir Quick Shortcut --}}
        <div class="space-y-3">
            {{-- POS Kasir --}}
            <a href="{{ route('pos') }}"
               class="flex items-center gap-4 p-4 rounded-2xl hover:shadow-lg hover:scale-105 transition-all duration-200"
               style="background: linear-gradient(to right, #f97316, #ea580c)">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: rgba(255,255,255,0.2)">
                    <svg class="w-6 h-6" style="color:white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold" style="color:white">Buka POS Kasir</p>
                    <p class="text-sm" style="color:rgba(255,255,255,0.75)">Mulai transaksi baru</p>
                </div>
            </a>

            {{-- Lihat Produk --}}
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-4 p-4 bg-white border border-gray-100 rounded-2xl hover:shadow-md hover:scale-105 transition-all duration-200">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Lihat Produk</p>
                    <p class="text-sm text-gray-400">Cek stok &amp; katalog</p>
                </div>
            </a>

            {{-- Riwayat Transaksi --}}
            <a href="{{ route('transactions.index') }}"
               class="flex items-center gap-4 p-4 bg-white border border-gray-100 rounded-2xl hover:shadow-md hover:scale-105 transition-all duration-200">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Riwayat Transaksi</p>
                    <p class="text-sm text-gray-400">Lihat transaksi sebelumnya</p>
                </div>
            </a>
        </div>
    </div>
    @endif

    @if(auth()->user()->role === 'admin')
    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        {{-- POS Kasir --}}
        <a href="{{ route('pos') }}" class="bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-5 text-white flex items-center gap-3 hover:shadow-lg hover:scale-105 transition-all duration-200">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor"/>
                    <path d="M8 21h8M12 17v4" stroke="currentColor" stroke-linecap="round"/>
                    <path d="M7 8h4M7 11h2" stroke="currentColor" stroke-linecap="round"/>
                    <rect x="13" y="7" width="4" height="5" rx="1" stroke="currentColor"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-sm leading-tight">POS Kasir</p>
                <p class="text-xs text-orange-100 mt-0.5">Mulai transaksi</p>
            </div>
        </a>
        {{-- Produk --}}
        <a href="{{ route('products.index') }}" class="bg-white rounded-2xl p-5 flex items-center gap-3 border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-200">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="currentColor"/>
                    <path d="M9 22V12h6v10" stroke="currentColor" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-gray-800 leading-tight">Produk</p>
                <p class="text-xs text-gray-400 mt-0.5">Kelola stok</p>
            </div>
        </a>
        {{-- Pelanggan --}}
        <a href="{{ route('customers.index') }}" class="bg-white rounded-2xl p-5 flex items-center gap-3 border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-200">
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <circle cx="9" cy="7" r="4" stroke="currentColor"/>
                    <path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" stroke="currentColor" stroke-linecap="round"/>
                    <path d="M16 3.13a4 4 0 010 7.75M21 21v-2a4 4 0 00-3-3.87" stroke="currentColor" stroke-linecap="round"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-gray-800 leading-tight">Pelanggan</p>
                <p class="text-xs text-gray-400 mt-0.5">Data member</p>
            </div>
        </a>
        {{-- Laporan --}}
        <a href="{{ route('reports.index') }}" class="bg-white rounded-2xl p-5 flex items-center gap-3 border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-200">
            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                    <path d="M4 20h16M4 20V10m0 10h4V10H4v10zm6 0V4m0 16h4V4h-4v16zm6 0V14m0 6h4v-6h-4v6z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-sm text-gray-800 leading-tight">Laporan</p>
                <p class="text-xs text-gray-400 mt-0.5">Analitik bisnis</p>
            </div>
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
@if(auth()->user()->role === 'admin')
<script>
    const grafikData = @json($grafikData);
    const labels = grafikData.map(d => d.tanggal);
    const omzet = grafikData.map(d => d.omzet);

    const options = {
        chart: { type: 'area', height: 280, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
        series: [{ name: 'Omzet (Rp)', data: omzet }],
        xaxis: { categories: labels, labels: { style: { colors: '#9ca3af', fontSize: '12px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: {
            labels: {
                style: { colors: '#9ca3af', fontSize: '11px' },
                formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
            }
        },
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05, stops: [0, 100] }
        },
        stroke: { curve: 'smooth', width: 3, colors: ['#14b8a6'] },
        colors: ['#14b8a6'],
        grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
        dataLabels: { enabled: false },
        tooltip: {
            y: { formatter: val => 'Rp ' + new Intl.NumberFormat('id-ID').format(val) }
        },
        markers: { size: 4, colors: ['#14b8a6'], strokeColors: '#fff', strokeWidth: 2 },
    };

    const chart = new ApexCharts(document.querySelector('#chartPenjualan'), options);
    chart.render();
</script>
@endif
@endpush