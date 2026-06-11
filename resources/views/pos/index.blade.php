@php use Illuminate\Support\Facades\Storage; @endphp
@extends('layouts.app')
@section('title', 'POS Kasir')
@section('subtitle', 'Proses transaksi penjualan')

@push('styles')
<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    [x-cloak] { display: none !important; }
    main:has(#pos-wrapper) { padding: 0 !important; overflow: hidden !important; }
    input[type=number] { border: none !important; outline: none !important; box-shadow: none !important; -moz-appearance: textfield; }
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endpush

@section('content')
<div id="pos-wrapper" x-data="posApp()" class="flex overflow-hidden" style="height: calc(100vh - 56px);">

    {{-- PANEL KIRI: Daftar Produk --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">

        {{-- Search Bar --}}
        <div class="px-5 py-3 bg-white border-b border-gray-100 flex items-center gap-3 flex-shrink-0">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" x-model="searchQuery"
                    class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-transparent rounded-xl text-sm focus:bg-white focus:border-orange-300 focus:ring-2 focus:ring-orange-100 transition-all outline-none"
                    placeholder="Cari nama produk atau kategori...">
            </div>
            <button @click="searchQuery = ''" x-show="searchQuery !== ''" x-cloak
                class="px-3 py-2 bg-red-50 text-red-500 hover:bg-red-100 rounded-xl text-xs font-semibold transition">
                Reset
            </button>
        </div>

        {{-- Status --}}
        <div class="px-5 py-2 flex items-center justify-between text-xs text-gray-500 bg-white border-b border-gray-50 flex-shrink-0">
            <p>Menampilkan <span class="font-bold text-gray-700">{{ count($products) }}</span> produk</p>
            <p x-show="cart.length > 0" x-cloak>
                <span class="text-orange-600 font-bold" x-text="cart.reduce((s,i)=>s+i.qty,0)"></span> item di keranjang
            </p>
        </div>

        {{-- Grid Produk --}}
        <div class="flex-1 overflow-y-auto p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @forelse($products as $product)
                @php
                    $imgUrl = $product->gambar_produk ? asset(Storage::url($product->gambar_produk)) : '';
                @endphp
                <div
                    x-show="searchQuery === '' || '{{ strtolower(addslashes($product->nama_produk)) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower(addslashes($product->kategori)) }}'.includes(searchQuery.toLowerCase())"
                    :class="cart.find(i=>i.id==={{ $product->id }}) ? 'ring-2 ring-orange-400 border-orange-400' : 'border-gray-200'"
                    class="bg-white rounded-xl border {{ $product->stok > 0 ? 'cursor-pointer hover:border-orange-300 hover:shadow-md' : 'opacity-60' }} transition-all overflow-hidden relative">

                    <div class="flex items-center p-3 gap-3"
                        @if($product->stok > 0) @click="addToCart({{ $product->id }}, '{{ addslashes($product->nama_produk) }}', {{ $product->harga }}, {{ $product->stok }}, '{{ addslashes($product->kategori) }}', '{{ addslashes($imgUrl) }}')" @endif>

                        {{-- Gambar --}}
                        <div class="w-12 h-12 flex-shrink-0 rounded-lg overflow-hidden relative bg-gray-100 flex items-center justify-center">
                            @if($product->gambar_produk)
                                <img src="{{ $imgUrl }}" class="w-full h-full object-cover" alt="{{ $product->nama_produk }}"
                                     onerror="this.style.display='none'">
                            @else
                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @endif
                            {{-- Badge qty --}}
                            <div x-cloak x-show="cart.find(i=>i.id==={{ $product->id }})"
                                 class="absolute -top-1 -left-1 w-5 h-5 bg-teal-500 text-white text-[10px] font-black rounded-full flex items-center justify-center shadow-sm">
                                <span x-text="(cart.find(i=>i.id==={{ $product->id }})||{qty:0}).qty"></span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-bold text-gray-800 truncate">{{ $product->nama_produk }}</h3>
                            <p class="text-[11px] text-gray-400 truncate">{{ $product->kategori }}</p>
                            <p class="text-[11px] mt-0.5 {{ $product->stok == 0 ? 'text-red-500 font-semibold' : ($product->stok <= 5 ? 'text-amber-500 font-semibold' : 'text-gray-500') }}">
                                Stok: {{ $product->stok }}
                            </p>
                        </div>

                        {{-- Harga & Tombol + --}}
                        <div class="flex flex-col items-end gap-1 flex-shrink-0">
                            <span class="text-xs font-black text-orange-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <button type="button"
                                @if($product->stok > 0) @click.stop="addToCart({{ $product->id }}, '{{ addslashes($product->nama_produk) }}', {{ $product->harga }}, {{ $product->stok }}, '{{ addslashes($product->kategori) }}', '{{ addslashes($imgUrl) }}')" @endif
                                {{ $product->stok == 0 ? 'disabled' : '' }}
                                class="w-7 h-7 flex items-center justify-center rounded-full text-white shadow-sm transition-all {{ $product->stok == 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600 active:scale-95' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-16 text-gray-400">
                    <p class="text-sm">Tidak ada produk tersedia</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PANEL KANAN: Keranjang + Pembayaran --}}
    <div class="flex flex-col bg-white border-l border-gray-200 flex-shrink-0" style="width:380px; min-width:380px; max-width:380px;">

        {{-- AREA SCROLL --}}
        <div class="flex-1 overflow-y-auto no-scrollbar">

            {{-- Header Keranjang --}}
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
                <div>
                    <h2 class="font-bold text-gray-800 text-lg">Keranjang Belanja</h2>
                    <p class="text-xs text-gray-500 mt-0.5" x-text="cart.reduce((s,i)=>s+i.qty,0) + ' item dipilih'"></p>
                </div>
                <button @click="cart = []; uangBayar = 0;" x-show="cart.length > 0" x-cloak
                    class="text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                    Kosongkan
                </button>
            </div>

            {{-- List Item Keranjang --}}
            <div class="bg-gray-50/50">
                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center py-10 text-gray-400">
                    <svg class="w-14 h-14 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <p class="text-sm font-medium">Keranjang masih kosong</p>
                    <p class="text-xs mt-1">Silakan pilih produk dari daftar</p>
                </div>

                <div class="px-4 py-2">
                    <template x-for="item in cart" :key="item.id">
                        <div class="py-3 border-b border-gray-100 last:border-b-0 flex gap-3">
                            <div class="w-12 h-12 flex-shrink-0 rounded-lg bg-gray-100 overflow-hidden flex items-center justify-center">
                                <img x-show="item.image" :src="item.image" class="w-full h-full object-cover">
                                <svg x-show="!item.image" class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 flex flex-col justify-between">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-bold text-gray-800 leading-tight truncate" x-text="item.nama"></h4>
                                        <p class="text-[10px] text-gray-400 mt-0.5 truncate" x-text="item.kategori"></p>
                                    </div>
                                    <button @click="removeFromCart(item.id)" class="text-gray-400 hover:text-red-500 transition p-1 flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between mt-2">
                                    <div class="flex items-center gap-2 bg-gray-100 rounded-full p-0.5">
                                        <button @click="decreaseQty(item.id)" class="w-6 h-6 rounded-full bg-white text-orange-500 hover:bg-orange-50 flex items-center justify-center shadow-sm font-bold text-lg leading-none">-</button>
                                        <span class="text-xs font-bold text-gray-700 w-4 text-center" x-text="item.qty"></span>
                                        <button @click="increaseQty(item.id)" class="w-6 h-6 rounded-full bg-orange-500 text-white hover:bg-orange-600 flex items-center justify-center shadow-sm font-bold text-lg leading-none">+</button>
                                    </div>
                                    <span class="text-sm font-black text-orange-600" x-text="'Rp ' + formatNumber(item.harga * item.qty)"></span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Pelanggan & Promo --}}
            <div class="px-5 py-3 border-t border-gray-100 space-y-2">
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs text-gray-400">Pelanggan</label>
                        <select x-model="customerId" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs mt-1 outline-none bg-white focus:border-orange-300">
                            <option value="">Umum</option>
                            @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400">Promo</label>
                        <select x-model="promoId" @change="if(promoId !== 'lain') { diskonManual = 0; namaDiskon = ''; }" class="w-full border border-gray-200 rounded-lg px-2 py-1.5 text-xs mt-1 outline-none bg-white focus:border-orange-300">
                            <option value="">Tanpa Promo</option>
                            @foreach($promos as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_promo }}</option>
                            @endforeach
                            <option value="lain">Diskon Lain...</option>
                        </select>
                    </div>
                </div>
                {{-- Form diskon manual — lebar penuh di bawah grid --}}
                <div x-show="promoId === 'lain'" x-cloak
                     class="rounded-xl overflow-hidden border border-orange-200 shadow-sm">
                    {{-- Header --}}
                    <div class="bg-orange-500 px-4 py-2 flex items-center gap-2">
                        <span class="text-base">🏷️</span>
                        <p class="text-xs font-bold text-white tracking-wide">Diskon Lain</p>
                    </div>
                    {{-- Body: 2 kolom sejajar --}}
                    <div class="bg-white px-4 py-3">
                        <div class="grid grid-cols-2 gap-3">
                            {{-- Nominal --}}
                            <div>
                                <label class="text-xs font-semibold text-gray-500">Nominal Diskon</label>
                                <div class="flex items-center mt-1 rounded-lg border border-gray-200 overflow-hidden focus-within:border-orange-400 focus-within:ring-2 focus-within:ring-orange-100 transition-all">
                                    <span class="px-2 py-2 bg-gray-50 text-gray-400 text-xs font-semibold border-r border-gray-200">Rp</span>
                                    <input type="number" x-model="diskonManual" min="0" :max="subtotal"
                                        class="w-0 flex-1 px-2 py-2 outline-none border-none text-xs font-bold text-red-500 bg-white text-right appearance-none"
                                        placeholder="0">
                                </div>
                            </div>
                            {{-- Nama --}}
                            <div>
                                <label class="text-xs font-semibold text-gray-500">Nama <span class="font-normal text-gray-300">opsional</span></label>
                                <input type="text" x-model="namaDiskon"
                                    class="w-full mt-1 border border-gray-200 rounded-lg bg-white px-3 py-2 text-xs outline-none focus:border-orange-400 focus:ring-2 focus:ring-orange-100 transition-all placeholder-gray-300"
                                    placeholder="cth: Diskon Hari Raya">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Diskon & Total --}}
            <div class="px-5 py-4 border-t border-gray-100 space-y-2">
                <div class="flex justify-between items-center text-xs text-gray-500">
                    <span>Subtotal</span>
                    <span class="font-semibold text-gray-700" x-text="'Rp ' + formatNumber(subtotal)"></span>
                </div>
                {{-- Diskon Promo --}}
                <div class="flex justify-between items-center text-xs text-gray-500" x-show="diskonPromo > 0">
                    <span>Diskon Promo</span>
                    <span class="font-semibold text-red-400" x-text="'- Rp ' + formatNumber(diskonPromo)"></span>
                </div>
                {{-- Diskon Manual --}}
                <div class="flex justify-between items-center text-xs text-gray-500" x-show="promoId === 'lain' && diskonManual > 0">
                    <span x-text="namaDiskon ? namaDiskon : 'Diskon Lain'"></span>
                    <span class="font-semibold text-red-400" x-text="'- Rp ' + formatNumber(parseInt(diskonManual)||0)"></span>
                </div>
                {{-- Total Diskon --}}
                <div class="flex justify-between items-center text-xs" x-show="diskon > 0">
                    <span class="font-semibold text-gray-600">Total Diskon</span>
                    <span class="font-bold text-red-500" x-text="'- Rp ' + formatNumber(diskon)"></span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                    <span class="text-sm font-black text-gray-800 tracking-wide">TOTAL</span>
                    <span class="text-xl font-black text-orange-600" x-text="'Rp ' + formatNumber(total)"></span>
                </div>
            </div>

            {{-- Metode Pembayaran --}}
            <div class="px-5 pb-4 space-y-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Metode Pembayaran</p>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" @click="metodeBayar='tunai'"
                        :class="metodeBayar==='tunai' ? 'bg-orange-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="py-2.5 rounded-xl text-xs font-semibold transition">Tunai</button>
                    <button type="button" @click="metodeBayar='transfer'"
                        :class="metodeBayar==='transfer' ? 'bg-orange-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="py-2.5 rounded-xl text-xs font-semibold transition">Transfer</button>
                    <button type="button" @click="metodeBayar='qris'"
                        :class="metodeBayar==='qris' ? 'bg-orange-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="py-2.5 rounded-xl text-xs font-semibold transition">QRIS</button>
                </div>

                {{-- TUNAI --}}
                <div x-show="metodeBayar==='tunai'" x-cloak class="space-y-2">
                    <div class="flex items-center border border-gray-200 rounded-xl px-3 py-2.5" style="background:#fff;">
                        <span class="text-gray-400 text-sm mr-2">Rp</span>
                        <input type="number" x-model="uangBayar" min="0"
                            style="background:#fff; color:#1f2937;"
                            class="flex-1 outline-none border-none text-right text-sm font-semibold appearance-none"
                            placeholder="0">
                    </div>
                    <div class="grid grid-cols-3 gap-1.5">
                        <button type="button" @click="uangBayar=total"
                            class="py-1.5 bg-orange-50 text-orange-600 hover:bg-orange-100 rounded-lg text-xs font-semibold">Uang Pas</button>
                        <button type="button" @click="uangBayar=50000"
                            class="py-1.5 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-xs">50.000</button>
                        <button type="button" @click="uangBayar=100000"
                            class="py-1.5 bg-gray-50 text-gray-600 hover:bg-gray-100 rounded-lg text-xs">100.000</button>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">Kembalian</span>
                        <span class="font-bold"
                            :class="uangBayar < total ? 'text-red-500' : 'text-teal-600'"
                            x-text="uangBayar < total ? 'Kurang Rp ' + formatNumber(total - uangBayar) : 'Rp ' + formatNumber(uangBayar - total)">
                        </span>
                    </div>
                </div>

                {{-- TRANSFER --}}
                <div x-show="metodeBayar==='transfer'" x-cloak class="space-y-2">
                    <p class="text-xs text-gray-500">Nomor referensi transfer (opsional)</p>
                    <input type="text" x-model="nomorReferensi" placeholder="No. Referensi..."
                        class="w-full border border-gray-200 rounded-xl bg-white px-4 py-2.5 text-sm outline-none focus:border-orange-400 transition">
                    <div class="flex justify-between items-center text-sm bg-teal-50 rounded-xl px-3 py-2">
                        <span class="text-teal-600">Total Transfer</span>
                        <span class="font-bold text-teal-700" x-text="'Rp ' + formatNumber(total)"></span>
                    </div>
                </div>

                {{-- QRIS --}}
                <div x-show="metodeBayar==='qris'" x-cloak class="text-center space-y-2">
                    <div class="border border-gray-200 rounded-xl p-3 bg-white inline-block">
                        <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=UMKMART-'+total"
                            width="150" height="150" alt="QR Code" class="rounded-lg">
                    </div>
                    <p class="text-sm font-semibold text-gray-700">Scan untuk Bayar</p>
                    <p class="text-lg font-bold text-orange-500" x-text="'Rp ' + formatNumber(total)"></p>
                    <p class="text-xs text-gray-400">Tunjukkan QR ini ke pelanggan</p>
                </div>
            </div>

        </div>{{-- /area scroll --}}

        {{-- TOMBOL PROSES — FIXED DI BAWAH --}}
        <div class="px-4 py-4 border-t border-gray-100 bg-white" style="flex-shrink:0;">
            <form id="posForm" method="POST" action="{{ route('pos.store') }}">
                @csrf
                <input type="hidden" name="customer_id" id="inp_customer">
                <input type="hidden" name="promo_id" id="inp_promo">
                <input type="hidden" name="metode_bayar" id="inp_metode" :value="metodeBayar">
                <input type="hidden" name="subtotal" id="inp_subtotal">
                <input type="hidden" name="diskon" id="inp_diskon">
                <input type="hidden" name="total" id="inp_total">
                <input type="hidden" name="bayar" id="inp_bayar">
                <input type="hidden" name="kembalian" id="inp_kembalian">
                <input type="hidden" name="nomor_referensi" id="inp_referensi">
                <input type="hidden" name="diskon_manual" id="inp_diskon_manual">
                <input type="hidden" name="nama_diskon" id="inp_nama_diskon">
                <div id="cartInputs"></div>

                <button type="button" @click="prosesTransaksi()"
                    :disabled="cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total)"
                    :class="(cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total))
                        ? 'bg-orange-400 opacity-50 cursor-not-allowed'
                        : 'bg-orange-500 hover:bg-orange-600 active:scale-[0.98] shadow-lg shadow-orange-200 opacity-100'"
                    class="w-full py-3 rounded-xl font-semibold text-white text-sm transition-all flex items-center justify-center gap-2">
                    🛒 Proses Pembayaran
                </button>
            </form>
        </div>

    </div>{{-- /panel kanan --}}

</div>
@endsection

@push('scripts')
<script>
function posApp() {
    return {
        promos: [
            @foreach($promos as $promo)
            { id: {{ $promo->id }}, tipe: '{{ $promo->tipe_diskon }}', nilai: {{ $promo->nilai_diskon }}, min: {{ $promo->minimal_belanja ?? 0 }} },
            @endforeach
        ],
        searchQuery:    '',
        cart:           [],
        customerId:     '',
        promoId:        '',
        metodeBayar:    'tunai',
        uangBayar:      0,
        nomorReferensi: '',
        diskonManual:   0,
        namaDiskon:     '',

        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.harga * item.qty), 0);
        },

        get diskonPromo() {
            if (!this.promoId || this.promoId === 'lain') return 0;
            const promo = this.promos.find(p => p.id == this.promoId);
            if (!promo || this.subtotal < promo.min) return 0;
            return promo.tipe === 'persen'
                ? Math.floor((this.subtotal * promo.nilai) / 100)
                : promo.nilai;
        },

        get diskon() {
            if (this.promoId === 'lain') {
                const manual = parseInt(this.diskonManual) || 0;
                return manual > this.subtotal ? this.subtotal : manual;
            }
            const total = this.diskonPromo;
            return total > this.subtotal ? this.subtotal : total;
        },

        get total() {
            const t = this.subtotal - this.diskon;
            return t > 0 ? t : 0;
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num || 0);
        },

        addToCart(id, nama, harga, stok, kategori, image) {
            if (stok <= 0) {
                Swal.fire({ icon: 'error', title: 'Stok Habis!', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });
                return;
            }
            const item = this.cart.find(i => i.id === id);
            if (item) {
                if (item.qty < stok) { item.qty++; }
                else { Swal.fire({ icon: 'warning', title: 'Stok Terbatas', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false }); }
            } else {
                this.cart.push({ id, nama, harga, qty: 1, stok, kategori, image });
            }
        },

        increaseQty(id) {
            const item = this.cart.find(i => i.id === id);
            if (item && item.qty < item.stok) item.qty++;
        },

        decreaseQty(id) {
            const item = this.cart.find(i => i.id === id);
            if (!item) return;
            if (item.qty > 1) { item.qty--; } else { this.removeFromCart(id); }
        },

        removeFromCart(id) {
            this.cart = this.cart.filter(i => i.id !== id);
        },

        prosesTransaksi() {
            if (this.cart.length === 0) {
                Swal.fire('Peringatan', 'Keranjang masih kosong!', 'warning');
                return;
            }
            if (this.metodeBayar === 'tunai' && this.uangBayar < this.total) {
                Swal.fire('Peringatan', 'Uang bayar tidak cukup!', 'warning');
                return;
            }

            // Set semua hidden input secara manual
            document.getElementById('inp_customer').value  = this.customerId;
            document.getElementById('inp_promo').value     = this.promoId;
            document.getElementById('inp_metode').value    = this.metodeBayar;
            document.getElementById('inp_subtotal').value  = this.subtotal;
            document.getElementById('inp_diskon').value    = this.diskon;
            document.getElementById('inp_total').value     = this.total;
            document.getElementById('inp_bayar').value     = this.metodeBayar === 'tunai' ? this.uangBayar : this.total;
            document.getElementById('inp_kembalian').value = this.metodeBayar === 'tunai' && this.uangBayar > this.total ? this.uangBayar - this.total : 0;
            document.getElementById('inp_referensi').value = this.nomorReferensi;
            document.getElementById('inp_diskon_manual').value = parseInt(this.diskonManual) || 0;
            document.getElementById('inp_nama_diskon').value = this.namaDiskon;

            // Build cart items
            const container = document.getElementById('cartInputs');
            container.innerHTML = '';
            this.cart.forEach((item, idx) => {
                container.innerHTML += `<input type="hidden" name="items[${idx}][product_id]" value="${item.id}">`;
                container.innerHTML += `<input type="hidden" name="items[${idx}][jumlah]" value="${item.qty}">`;
            });

            document.getElementById('posForm').submit();
        }
    };
}

window.addEventListener('pageshow', function(event) {
    if (event.persisted) window.location.reload();
});
</script>
@endpush