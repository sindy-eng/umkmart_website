<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UMKMART Sistem Manajemen UMKM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-amber-400 via-orange-500 to-orange-700 min-h-screen flex items-center justify-center overflow-hidden relative">

    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-orange-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-amber-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-orange-500/10 rounded-full blur-3xl animate-ping" style="animation-duration: 3s"></div>
    </div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-20 w-2 h-2 bg-white/20 rounded-full animate-bounce" style="animation-delay: 0s; animation-duration: 3s"></div>
        <div class="absolute top-40 right-32 w-3 h-3 bg-white/15 rounded-full animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s"></div>
        <div class="absolute bottom-32 left-40 w-2 h-2 bg-white/20 rounded-full animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s"></div>
        <div class="absolute bottom-20 right-20 w-1.5 h-1.5 bg-white/25 rounded-full animate-bounce" style="animation-delay: 1.5s; animation-duration: 2s"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-6" id="splashContent">

        <!-- Logo -->
        <div class="mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white/15 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 mb-6 animate-float">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-5xl sm:text-7xl font-black text-white tracking-tight mb-3 animate-slide-up">
            UMK<span class="text-yellow-300">MART</span>
        </h1>
        <p class="text-orange-100/80 text-lg sm:text-xl font-light mb-2 animate-slide-up" style="animation-delay: 0.2s">
            Sistem Manajemen Operasional & Marketing
        </p>
        <p class="text-orange-200/60 text-sm mb-12 animate-slide-up" style="animation-delay: 0.3s">
            Solusi lengkap untuk UMKM modern
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up" style="animation-delay: 0.5s">
            <a href="{{ route('login') }}" class="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-orange-700 font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 backdrop-blur text-white font-semibold rounded-2xl border border-white/20 hover:bg-white/20 hover:scale-105 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Daftar Baru
            </a>
        </div>

        <!-- Features -->
        <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.7s">

            <!-- POS Kasir -->
            <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/15 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                </div>
                <p class="text-white font-semibold text-sm text-left">POS Kasir</p>
                <p class="text-white font-semibold text-sm text-left">Transaksi cepat</p>
            </div>

            <!-- Laporan -->
            <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/15 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                </div>
                <p class="text-white font-semibold text-sm text-left">Laporan</p>
                <p class="text-white font-semibold text-sm text-left">Analisis bisnis</p>
            </div>

            <!-- Pelanggan -->
            <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/15 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                </div>
                <p class="text-white font-semibold text-sm text-left">Pelanggan</p>
                <p class="text-white font-semibold text-sm text-left">Kelola kontak</p>
            </div>

            <!-- WhatsApp -->
            <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/15 hover:bg-white/20 transition-all duration-300 group cursor-pointer">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>
                </div>
                <p class="text-white font-semibold text-sm text-left">WhatsApp</p>
                <p class="text-white font-semibold text-sm text-left">Broadcast pesan</p>
            </div>

        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-in { animation: fade-in 1s ease-out forwards; }
        .animate-slide-up { animation: slide-up 0.8s ease-out forwards; opacity: 0; }
        .animate-float { animation: float 3s ease-in-out infinite; }
    </style>
</body>
</html>