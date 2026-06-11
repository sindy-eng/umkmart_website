@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('subtitle', 'Kelola member & loyalty point')

@section('content')
<div class="space-y-5">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex gap-2 flex-1 sm:flex-none">
            <div class="relative flex-1 sm:w-72">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau WhatsApp..." class="w-full pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-medium transition">Cari</button>
        </form>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 text-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pelanggan
        </a>
        @endif
    </div>

    {{-- Tabel Pelanggan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">WhatsApp</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Transaksi</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Poin</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th class="text-center px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($customers as $customer)
                    <tr class="hover:bg-teal-50/20 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{ strtoupper(substr($customer->nama, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $customer->nama }}</p>
                                    @if($customer->alamat)
                                    <p class="text-xs text-gray-400 truncate max-w-xs">{{ $customer->alamat }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($customer->nomor_wa)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->nomor_wa) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 text-sm text-green-600 hover:text-green-700 font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                {{ $customer->nomor_wa }}
                            </a>
                            @else
                            <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            <a href="{{ route('customers.riwayat', $customer) }}" class="text-sm font-bold text-teal-600 hover:underline">
                                {{ $customer->transactions_count ?? 0 }} transaksi
                            </a>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-bold">
                                ⭐ {{ $customer->total_poin ?? 0 }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $customer->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $customer->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-gray-500">{{ $customer->created_at->format('d M Y') }}</span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('customers.riwayat', $customer) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Riwayat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('customers.edit', $customer) }}" class="p-2 text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Hapus pelanggan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p class="text-sm">Belum ada pelanggan.
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('customers.create') }}" class="text-teal-600 font-semibold">Tambah sekarang</a>
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $customers->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
