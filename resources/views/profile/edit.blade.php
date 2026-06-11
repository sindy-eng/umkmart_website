@extends('layouts.app')

@section('title', 'Pengaturan Akun')
@section('subtitle', 'Kelola profil dan keamanan akun')

@section('content')
<div class="max-w-2xl space-y-5 pt-4">

    {{-- ===== Card Avatar + Info Akun ===== --}}
    <div class="flex items-center gap-4 p-5 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-bold flex-shrink-0"
            style="background: linear-gradient(135deg, #f59e0b, #ea580c)">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-lg font-bold text-gray-800">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>
            <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold
                {{ auth()->user()->role === 'admin' ? 'bg-orange-100 text-orange-600' : 'bg-teal-100 text-teal-600' }}">
                {{ ucfirst(auth()->user()->role ?? 'kasir') }}
            </span>
        </div>
    </div>

    {{-- ===== Form Informasi Profil ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-800">Informasi Profil</h3>
            <p class="text-xs text-gray-400 mt-0.5">Perbarui nama dan alamat email akun Anda</p>
        </div>
        <div class="p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- ===== Form Ganti Password ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-800">Keamanan Akun</h3>
            <p class="text-xs text-gray-400 mt-0.5">Pastikan akun Anda menggunakan password yang kuat</p>
        </div>
        <div class="p-6">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- ===== Zona Berbahaya ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-50 bg-red-50/50">
            <h3 class="font-bold text-red-600">Zona Berbahaya</h3>
            <p class="text-xs text-gray-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
        </div>
        <div class="p-6">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
