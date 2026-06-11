<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — UMKMART</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;min-height:100vh;background:#f8fafc}
        .wrap{display:flex;min-height:100vh}
        .left{width:45%;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(145deg,#f59e0b,#ea580c);position:relative;overflow:hidden;padding:3rem}
        .left::before{content:'';position:absolute;top:-120px;right:-120px;width:320px;height:320px;background:rgba(255,255,255,.08);border-radius:50%}
        .left::after{content:'';position:absolute;bottom:-80px;left:-80px;width:240px;height:240px;background:rgba(255,255,255,.06);border-radius:50%}
        .left-inner{position:relative;z-index:1;max-width:400px;text-align:center}
        .logo{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:1.5rem}
        .logo-icon{width:52px;height:52px;background:rgba(255,255,255,.2);backdrop-filter:blur(10px);border-radius:16px;display:flex;align-items:center;justify-content:center}
        .logo-icon svg{width:28px;height:28px;color:#fff}
        .logo-text{font-size:2rem;font-weight:800}
        .logo-w{color:#fff}.logo-y{color:#fde047}
        .tagline{color:rgba(255,255,255,.9);font-size:1.05rem;font-weight:500;margin-bottom:2.5rem;line-height:1.6}
        .features{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .feat{background:rgba(255,255,255,.12);backdrop-filter:blur(8px);border-radius:16px;padding:18px 14px;text-align:center;transition:transform .2s}
        .feat:hover{background:rgba(255,255,255,.18);transform:translateY(-2px)}
        .feat-icon{width:42px;height:42px;background:rgba(255,255,255,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 8px}
        .feat-icon svg{width:20px;height:20px;color:#fff}
        .feat h4{color:#fff;font-size:.82rem;font-weight:700;margin-bottom:3px}
        .feat p{color:rgba(255,255,255,.7);font-size:.72rem;line-height:1.4}
        .right{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem}
        .form-wrap{width:100%;max-width:420px}
        .m-logo{display:none;text-align:center;margin-bottom:2rem}
        .m-logo-text{font-size:1.5rem;font-weight:800}
        .m-logo-text .mw{color:#ea580c}.m-logo-text .my{color:#f59e0b}
        .fh h2{font-size:1.7rem;font-weight:800;color:#1e293b;margin-bottom:6px}
        .fh p{color:#94a3b8;font-size:.9rem;margin-bottom:2rem}
        .fg{margin-bottom:1.2rem}
        .fl{display:block;font-size:.85rem;font-weight:600;color:#374151;margin-bottom:6px}
        .fi{width:100%;padding:12px 16px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:.9rem;font-family:inherit;background:#fff;transition:all .2s;outline:none;color:#1e293b}
        .fi:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.1)}
        .fi.err{border-color:#ef4444}
        .fe{color:#ef4444;font-size:.78rem;margin-top:4px}
        .fr{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
        .fc{display:flex;align-items:center;gap:8px;cursor:pointer}
        .fc input{width:18px;height:18px;accent-color:#f97316;cursor:pointer}
        .fc span{font-size:.85rem;color:#64748b}
        .ff{font-size:.85rem;color:#f97316;text-decoration:none;font-weight:600}
        .ff:hover{color:#ea580c;text-decoration:underline}
        .btn{width:100%;padding:13px;background:#f97316;color:#fff;border:none;border-radius:12px;font-size:.95rem;font-weight:700;font-family:inherit;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px}
        .btn:hover{background:#ea580c;transform:translateY(-1px);box-shadow:0 8px 24px rgba(234,88,12,.3)}
        .foot{text-align:center;margin-top:1.75rem;font-size:.88rem;color:#94a3b8}
        .foot a{color:#f97316;font-weight:600;text-decoration:none}
        .foot a:hover{text-decoration:underline}
        @media(max-width:768px){.left{display:none}.m-logo{display:block}}
    </style>
</head>
<body>
<div class="wrap">
    <div class="left">
        <div class="left-inner">
            <div class="logo">
                <div class="logo-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg></div>
                <div class="logo-text"><span class="logo-w">UMK</span><span class="logo-y">MART</span></div>
            </div>
            <p class="tagline">Sistem Manajemen Operasional &amp; Marketing untuk UMKM Modern</p>
            <div class="features">
                <div class="feat">
                    <div class="feat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg></div>
                    <h4>POS Kasir</h4><p>Transaksi cepat &amp; akurat</p>
                </div>
                <div class="feat">
                    <div class="feat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg></div>
                    <h4>Stok Realtime</h4><p>Pantau inventaris otomatis</p>
                </div>
                <div class="feat">
                    <div class="feat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                    <h4>Laporan Lengkap</h4><p>Export PDF &amp; Excel</p>
                </div>
                <div class="feat">
                    <div class="feat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <h4>Pelanggan &amp; Promo</h4><p>Loyalty &amp; marketing</p>
                </div>
            </div>
        </div>
    </div>
    <div class="right">
        <div class="form-wrap">
            <div class="m-logo">
                <div class="m-logo-text"><span class="mw">UMK</span><span class="my">MART</span></div>
                <p style="color:#94a3b8;font-size:.85rem;margin-top:4px">Sistem Manajemen UMKM</p>
            </div>
            <div class="fh">
                <h2>Selamat Datang! 👋</h2>
                <p>Masuk ke akun UMKMART Anda</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="fg">
                    <label class="fl" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="fi @error('email') err @enderror" placeholder="nama@email.com">
                    @error('email')<p class="fe">{{ $message }}</p>@enderror
                </div>
                <div class="fg">
                    <label class="fl" for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="fi @error('password') err @enderror" placeholder="••••••••">
                    @error('password')<p class="fe">{{ $message }}</p>@enderror
                </div>
                <div class="fr">
                    <label class="fc"><input type="checkbox" name="remember"><span>Ingat saya</span></label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="ff">Lupa password?</a>
                    @endif
                </div>
                <button type="submit" class="btn">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Masuk
                </button>
            </form>
            <div class="foot">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></div>
        </div>
    </div>
</div>
</body>
</html>
