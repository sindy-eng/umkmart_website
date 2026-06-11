@extends('layouts.app')

@section('title', 'Promo & Diskon')
@section('subtitle', 'Kelola diskon dan broadcast WhatsApp')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex gap-2 flex-1 sm:flex-none">
            <div class="relative flex-1 sm:w-72">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari promo..."
                    class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 rounded-lg text-sm font-medium transition">
                Cari
            </button>
        </form>

        <a href="{{ route('promos.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg text-sm transition-colors whitespace-nowrap shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Promo Baru
        </a>
    </div>

    {{-- Grid Promo --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($promos as $promo)
        @php
            $now = now();
            $isActive = $promo->aktif && $now->between($promo->tanggal_mulai, $promo->tanggal_selesai);
            $isExpired = $now->isAfter($promo->tanggal_selesai);
        @endphp

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">

            {{-- Colored top border --}}
            <div class="h-1 w-full {{ $isActive ? 'bg-orange-500' : ($isExpired ? 'bg-gray-300' : 'bg-blue-400') }}"></div>

            <div class="p-5">
                {{-- Title & Status --}}
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 text-sm leading-snug truncate">{{ $promo->nama_promo }}</h3>
                        @if($promo->deskripsi)
                            <p class="text-xs text-gray-400 mt-1 line-clamp-1">{{ $promo->deskripsi }}</p>
                        @endif
                    </div>
                    <span class="flex-shrink-0 text-xs font-medium px-2.5 py-1 rounded-md
                        {{ $isActive ? 'bg-green-50 text-green-700 border border-green-200' :
                           ($isExpired ? 'bg-gray-100 text-gray-500 border border-gray-200' :
                           'bg-blue-50 text-blue-600 border border-blue-200') }}">
                        {{ $isActive ? 'Aktif' : ($isExpired ? 'Berakhir' : 'Belum Mulai') }}
                    </span>
                </div>

                {{-- Discount Value --}}
                <div class="flex items-center gap-3 bg-gray-50 rounded-lg px-4 py-3 mb-4 border border-gray-100">
                    <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800 leading-none">
                            {{ $promo->tipe_diskon === 'persen'
                                ? rtrim(rtrim($promo->nilai_diskon, '0'), '.') . '%'
                                : 'Rp ' . number_format($promo->nilai_diskon, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $promo->tipe_diskon === 'persen' ? 'Diskon Persen' : 'Diskon Nominal' }}
                        </p>
                    </div>
                </div>

                {{-- Periode --}}
                <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>
                        {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M Y') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
                    </span>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                    <a href="{{ route('promos.broadcast', $promo) }}"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-green-50 hover:bg-green-100 text-green-700 rounded-lg text-xs font-semibold transition-colors border border-green-100">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.062.522 4.04 1.476 5.786L0 24l6.385-1.473A11.955 11.955 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.927 0-3.784-.5-5.417-1.419l-.388-.229-4.015.924.972-3.924-.248-.4A9.951 9.951 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                        </svg>
                        Broadcast WA
                    </a>
                    <a href="{{ route('promos.edit', $promo) }}"
                        class="p-2 text-gray-500 hover:text-orange-500 hover:bg-orange-50 rounded-lg transition-colors border border-gray-100"
                        title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('promos.destroy', $promo) }}" onsubmit="return confirm('Hapus promo ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-gray-100"
                            title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @empty
        <div class="sm:col-span-2 xl:col-span-3">
            <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                <div class="w-14 h-14 mx-auto mb-4 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-500 mb-1">Belum ada promo</p>
                <p class="text-xs text-gray-400 mb-4">Buat promo pertama untuk mulai menarik pelanggan</p>
                <a href="{{ route('promos.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Promo Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($promos->hasPages())
    <div class="bg-white rounded-xl border border-gray-200 px-4 py-3">
        {{ $promos->withQueryString()->links() }}
    </div>
    @endif

</div>
@endsection