@extends('layouts.app')

@section('title', 'Broadcast WhatsApp')
@section('subtitle', 'Kirim pesan promo ke pelanggan via WhatsApp')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">


    {{-- ===== Peringatan Popup ===== --}}
    <div id="popupWarning" class="bg-amber-50 rounded-2xl p-5 border border-amber-200 flex items-start gap-4">
        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-bold text-amber-800">Izinkan Popup Browser</p>
            <p class="text-sm text-amber-700 mt-1 leading-relaxed">
                Untuk membuka WhatsApp per pelanggan, browser perlu izin <strong>popup</strong>.<br>
                Jika tab tidak terbuka: klik ikon 🔒 di address bar → <strong>Izinkan popup</strong> untuk situs ini → coba lagi.
            </p>
        </div>
    </div>

    {{-- ===== Grid 2 Kolom ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ========== KOLOM KIRI: Preview Pesan + Pilih Penerima ========== --}}
        <div class="space-y-6">

            {{-- Template Pesan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-bold text-gray-700">Template Pesan WhatsApp</label>
                    <button onclick="salinPesan()" type="button"
                        class="text-xs px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg font-medium hover:bg-gray-200 transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Salin
                    </button>
                </div>
                <textarea id="pesanWa" rows="10"
                    class="w-full min-h-64 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 resize-y font-mono bg-gray-50 transition leading-relaxed">🎉 *{{ $promo->nama_promo }}* 🎉

Halo, kami punya penawaran spesial untuk Anda!

💰 Diskon: {{ $promo->tipe_diskon === 'persen' ? $promo->nilai_diskon.'%' : 'Rp '.number_format($promo->nilai_diskon, 0, ',', '.') }}
📅 Berlaku: {{ \Carbon\Carbon::parse($promo->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($promo->tanggal_selesai)->format('d M Y') }}
{{ $promo->deskripsi ? "\n".$promo->deskripsi."\n" : '' }}
Kunjungi kami sekarang dan dapatkan penawaran terbaik! 🛒</textarea>
                <p class="text-xs text-gray-400 mt-2">Pesan dapat diedit bebas sebelum dikirim.</p>
            </div>

            {{-- Daftar Pelanggan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold text-gray-700">Pilih Penerima</p>
                        <p class="text-xs text-gray-400 mt-0.5" id="selectedCount">
                            {{ $customers->count() }} dari {{ $customers->count() }} dipilih
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="checkAll(true)" type="button"
                            class="text-xs px-3 py-1.5 bg-teal-50 text-teal-700 rounded-lg font-medium hover:bg-teal-100 transition">
                            Pilih Semua
                        </button>
                        <button onclick="checkAll(false)" type="button"
                            class="text-xs px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg font-medium hover:bg-gray-200 transition">
                            Batal Semua
                        </button>
                    </div>
                </div>

                @if($customers->count() > 0)
                <div class="max-h-72 overflow-y-auto border border-gray-100 rounded-xl divide-y divide-gray-100">
                    @foreach($customers as $customer)
                    <label class="flex items-center gap-4 px-4 py-3 hover:bg-teal-50/50 cursor-pointer transition">
                        <input type="checkbox"
                            class="customer-cb w-4 h-4 rounded border-gray-300 text-teal-500 focus:ring-teal-400 cursor-pointer flex-shrink-0"
                            value="{{ $customer->nomor_wa }}"
                            data-nama="{{ $customer->nama }}"
                            checked>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $customer->nama }}</p>
                            <p class="text-sm text-gray-400 mt-0.5">{{ $customer->nomor_wa }}</p>
                        </div>
                        <span class="flex-shrink-0 text-[11px] px-2.5 py-1 bg-green-100 text-green-700 rounded-full font-semibold">WA</span>
                    </label>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                    <p class="text-sm font-medium">Belum ada pelanggan dengan nomor WA terdaftar.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ========== KOLOM KANAN: Cara Kirim + Log ========== --}}
        <div class="space-y-6">

            {{-- Progress Panel (hidden saat idle) --}}
            <div id="progressPanel" class="hidden bg-white rounded-2xl shadow-sm border border-teal-200 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-teal-600 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-800">Sedang Mengirim...</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate" id="progressText">Mempersiapkan...</p>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2.5 mb-2">
                    <div id="progressBar" class="bg-gradient-to-r from-teal-400 to-green-500 h-2.5 rounded-full transition-all duration-500" style="width:0%"></div>
                </div>
                <p class="text-xs text-gray-400 text-right mt-1" id="progressFraction">0 / 0</p>
            </div>

            {{-- Card Cara Kirim --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Pilih Cara Kirim</p>

                <div class="space-y-4">

                    {{-- Option A --}}
                    <div class="rounded-2xl border-2 border-green-200 bg-green-50 p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-7 h-7 rounded-full bg-green-500 text-white text-xs font-black flex items-center justify-center flex-shrink-0">A</div>
                            <p class="text-sm font-bold text-green-800">Kirim Satu per Satu</p>
                        </div>
                        <p class="text-sm text-green-700 mb-4">
                            Buka tab WA baru per pelanggan dengan jeda 2 detik. Tampilkan progress real-time. Pastikan izin popup aktif.
                        </p>
                        <button id="btnBroadcast" onclick="broadcastSatuPerSatu()" type="button"
                            class="w-full py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition text-sm flex items-center justify-center gap-2 active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Kirim via WhatsApp
                        </button>
                    </div>


                </div>
            </div>

            {{-- Saluran WhatsApp --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-xl">
                        📢
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Kirim ke Saluran WhatsApp</h3>
                        <p class="text-xs text-gray-500">Bagikan promo ke saluran resmi UMKMART</p>
                    </div>
                </div>
                <p class="text-sm text-gray-600 mb-4">
                    Klik tombol di bawah untuk membuka saluran WhatsApp UMKMART dan bagikan pesan promo secara langsung kepada semua pengikut saluran.
                </p>
                <a href="https://whatsapp.com/channel/0029VbDAehL7YSdC3biQbb0T"
                   target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition">
                    Buka Saluran WhatsApp UMKMART
                </a>
                <button onclick="navigator.clipboard.writeText('https://whatsapp.com/channel/0029VbDAehL7YSdC3biQbb0T').then(() => Swal.fire({ icon: 'success', title: 'Link Disalin!', text: 'Link saluran berhasil disalin ke clipboard.', timer: 2000, showConfirmButton: false, toast: true, position: 'top-end' }))"
                    class="w-full mt-2 py-2 border border-green-300 text-green-600 text-sm font-medium rounded-xl hover:bg-green-100 transition">
                    🔗 Salin Link Saluran
                </button>
                <p class="text-xs text-gray-400 text-center mt-2">
                    Akan membuka WhatsApp, pastikan Anda sudah login
                </p>
            </div>

            {{-- Log Broadcast --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6" id="broadcastLog">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Log Broadcast</p>
                @if($promo->last_broadcast_at)
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Terakhir dikirim</span>
                        <span class="text-sm font-semibold text-gray-800">{{ $promo->last_broadcast_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total pengiriman</span>
                        <span class="text-sm font-bold text-teal-600">{{ number_format($promo->broadcast_count) }} pelanggan</span>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3 text-gray-400">
                    <svg class="w-8 h-8 text-gray-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm italic">Belum pernah di-broadcast.</p>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const LOG_URL = '{{ route('promos.broadcast-log', $promo) }}';
const CSRF    = '{{ csrf_token() }}';

function formatNomor(nomor) {
    let n = nomor.replace(/[^0-9]/g, '');
    if (n.startsWith('0')) n = '62' + n.slice(1);
    return n;
}

function updateCount() {
    const total   = document.querySelectorAll('.customer-cb').length;
    const checked = document.querySelectorAll('.customer-cb:checked').length;
    document.getElementById('selectedCount').textContent = `${checked} dari ${total} dipilih`;
}

document.querySelectorAll('.customer-cb').forEach(cb => cb.addEventListener('change', updateCount));

function checkAll(val) {
    document.querySelectorAll('.customer-cb').forEach(cb => cb.checked = val);
    updateCount();
}

function broadcastSatuPerSatu() {
    const checked = [...document.querySelectorAll('.customer-cb:checked')];
    if (checked.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Pilih Pelanggan', text: 'Pilih minimal 1 pelanggan untuk broadcast.', confirmButtonColor: '#0d9488' });
        return;
    }

    const pesan     = encodeURIComponent(document.getElementById('pesanWa').value);
    const customers = checked.map(cb => ({ nomor: formatNomor(cb.value), nama: cb.dataset.nama }));
    const total     = customers.length;

    const progressPanel    = document.getElementById('progressPanel');
    const progressBar      = document.getElementById('progressBar');
    const progressText     = document.getElementById('progressText');
    const progressFraction = document.getElementById('progressFraction');
    const btnBroadcast     = document.getElementById('btnBroadcast');

    progressPanel.classList.remove('hidden');
    btnBroadcast.disabled = true;
    btnBroadcast.classList.add('opacity-60', 'cursor-not-allowed');

    let idx = 0, delay = 0;

    customers.forEach(c => {
        setTimeout(() => {
            idx++;
            const pct = Math.round((idx / total) * 100);
            progressText.textContent     = `Membuka WhatsApp ${idx} dari ${total}... (${c.nama})`;
            progressBar.style.width      = pct + '%';
            progressFraction.textContent = `${idx} / ${total}`;
            window.open(`https://wa.me/${c.nomor}?text=${pesan}`, '_blank');

            if (idx === total) {
                setTimeout(() => {
                    progressPanel.classList.add('hidden');
                    btnBroadcast.disabled = false;
                    btnBroadcast.classList.remove('opacity-60', 'cursor-not-allowed');
                    progressBar.style.width = '0%';
                    saveBroadcastLog(total);
                    Swal.fire({
                        icon: 'success',
                        title: 'Broadcast Selesai!',
                        html: `<p>Berhasil membuka WhatsApp untuk <strong>${total} pelanggan</strong>.</p><p class="text-sm text-gray-500 mt-1">Log telah disimpan di database.</p>`,
                        confirmButtonColor: '#0d9488',
                        confirmButtonText: 'Tutup'
                    });
                }, 1500);
            }
        }, delay);
        delay += 2000;
    });
}

function salinNomor() {
    const checked = [...document.querySelectorAll('.customer-cb:checked')];
    if (checked.length === 0) {
        Swal.fire({ icon: 'warning', title: 'Tidak ada yang dipilih', text: 'Pilih minimal 1 pelanggan.', confirmButtonColor: '#0d9488' });
        return;
    }
    const nomors = checked.map(cb => formatNomor(cb.value)).join(', ');
    const doAlert = () => Swal.fire({
        icon: 'success', title: 'Nomor Disalin!',
        html: `<p><strong>${checked.length} nomor</strong> berhasil disalin ke clipboard.</p><p class="text-xs text-gray-500 mt-2 font-mono break-all">${nomors.substring(0,120)}${nomors.length>120?'...':''}</p>`,
        confirmButtonColor: '#3b82f6', timer: 4000
    });
    navigator.clipboard.writeText(nomors).then(doAlert).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = nomors; document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta);
        doAlert();
    });
}

function salinPesan() {
    const pesan = document.getElementById('pesanWa').value;
    const doAlert = () => Swal.fire({ icon: 'success', title: 'Pesan Disalin!', text: 'Template pesan berhasil disalin ke clipboard.', confirmButtonColor: '#6b7280', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
    navigator.clipboard.writeText(pesan).then(doAlert).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = pesan; document.body.appendChild(ta); ta.select();
        document.execCommand('copy'); document.body.removeChild(ta);
        doAlert();
    });
}

function saveBroadcastLog(jumlah) {
    fetch(LOG_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: JSON.stringify({ jumlah }),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('broadcastLog').innerHTML = `
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Log Broadcast</p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Terakhir dikirim</span>
                        <span class="text-sm font-semibold text-gray-800">${data.last_broadcast_at}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Total pengiriman</span>
                        <span class="text-sm font-bold text-teal-600">${data.broadcast_count} pelanggan</span>
                    </div>
                </div>`;
        }
    })
    .catch(err => console.warn('Gagal menyimpan log broadcast:', err));
}
</script>
@endpush
