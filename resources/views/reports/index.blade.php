@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('subtitle', 'Analitik omzet dan pengeluaran')

@section('content')
<div class="space-y-5">

    {{-- Filter Bulan + Export --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex flex-wrap gap-3 items-end">
        <form method="GET" class="flex gap-3 items-end flex-wrap flex-1">
            <div>
                <label class="text-xs font-semibold text-gray-500 block mb-1.5">Pilih Bulan</label>
                <input type="month" name="bulan" value="{{ $bulan }}" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
            </div>
            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-amber-400 to-orange-600 text-white rounded-xl text-sm font-semibold hover:shadow-md transition">Tampilkan</button>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('reports.excel', ['bulan' => $bulan]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Excel
            </a>
            <a href="{{ route('reports.pdf', ['bulan' => $bulan]) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                PDF
            </a>
        </div>
    </div>

    {{-- 4 Kartu Ringkasan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-teal-400 to-teal-600 rounded-2xl p-5">
            <p class="text-xs font-semibold text-teal-100 uppercase tracking-wider mb-2">Total Omzet</p>
            <p class="text-2xl font-black text-white">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</p>
            <p class="text-xs text-teal-100 mt-1">{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Transaksi</p>
            <p class="text-2xl font-black text-gray-800">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Transaksi selesai</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pengeluaran</p>
            <p class="text-2xl font-black text-red-500">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Semua kategori</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Laba Bersih</p>
            <p class="text-2xl font-black {{ $labaBersih >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format(abs($labaBersih), 0, ',', '.') }}
            </p>
            <p class="text-xs text-gray-400 mt-1">{{ $labaBersih >= 0 ? 'Untung' : 'Rugi' }}</p>
        </div>
    </div>

    {{-- Grafik Omzet Harian + Trend 12 Bulan --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Omzet Harian --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-1">Omzet Harian</h3>
            <p class="text-xs text-gray-400 mb-5">{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</p>
            <div id="chartOmzetHarian"></div>
        </div>

        {{-- Trend 12 Bulan --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-1">Trend Omzet</h3>
            <p class="text-xs text-gray-400 mb-5">12 bulan terakhir</p>
            <div id="chartTrend"></div>
        </div>
    </div>

    {{-- Produk Terlaris + Pengeluaran Kategori --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Produk Terlaris --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-5">Produk Terlaris Bulan Ini</h3>
            <div class="space-y-3">
                @forelse($produkTerlaris as $i => $item)
                <div class="flex items-center gap-3">
                    <span class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-black flex-shrink-0
                        {{ $i === 0 ? 'bg-amber-400 text-white' : ($i === 1 ? 'bg-gray-200 text-gray-600' : 'bg-gray-100 text-gray-500') }}">
                        {{ $i + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->product?->nama_produk ?? 'Produk dihapus' }}</p>
                        <div class="mt-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            @php $maxTerjual = $produkTerlaris->first()?->total_terjual ?? 1; @endphp
                            <div class="h-full bg-gradient-to-r from-orange-400 to-teal-400 rounded-full" style="width: {{ ($item->total_terjual / $maxTerjual) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-xs font-bold text-gray-800">{{ $item->total_terjual }} pcs</p>
                        <p class="text-xs text-teal-600">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-sm text-gray-400 py-8">Belum ada data penjualan bulan ini</p>
                @endforelse
            </div>
        </div>

        {{-- Pengeluaran per Kategori --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-5">Pengeluaran per Kategori</h3>
            @if($pengeluaranKategori->count() > 0)
            <div id="chartPengeluaran" class="mb-4"></div>
            @else
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-sm">Belum ada pengeluaran bulan ini</p>
            </div>
            @endif
            <div class="space-y-2">
                @foreach($pengeluaranKategori as $kat)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">{{ $kat->kategori }}</span>
                    <span class="font-bold text-gray-800">Rp {{ number_format($kat->total, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Tabel Omzet Harian --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Detail Omzet Harian</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Jumlah Transaksi</th>
                        <th class="text-right px-5 py-3.5 text-xs font-semibold text-gray-500 uppercase">Omzet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($omzetHarian as $row)
                    <tr class="hover:bg-teal-50/20 transition-colors">
                        <td class="px-5 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-sm text-right text-gray-600">{{ $row->jumlah }}</td>
                        <td class="px-5 py-3 text-sm text-right font-bold text-teal-600">Rp {{ number_format($row->omzet, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-8 text-center text-sm text-gray-400">Tidak ada transaksi pada bulan ini</td></tr>
                    @endforelse
                </tbody>
                @if($omzetHarian->count() > 0)
                <tfoot>
                    <tr class="bg-teal-50 font-bold">
                        <td class="px-5 py-3 text-sm text-gray-700">Total</td>
                        <td class="px-5 py-3 text-sm text-right text-gray-700">{{ $totalTransaksi }}</td>
                        <td class="px-5 py-3 text-sm text-right text-teal-700">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Grafik Omzet Harian
const omzetHarianData = @json($omzetHarian);
if (omzetHarianData.length > 0) {
    new ApexCharts(document.querySelector('#chartOmzetHarian'), {
        chart: { type: 'bar', height: 250, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
        series: [{ name: 'Omzet', data: omzetHarianData.map(d => d.omzet) }],
        xaxis: { categories: omzetHarianData.map(d => d.tanggal), labels: { style: { colors: '#9ca3af', fontSize: '10px' }, rotate: -30 } },
        yaxis: { labels: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v), style: { colors: '#9ca3af', fontSize: '10px' } } },
        colors: ['#f97316'],
        plotOptions: { bar: { borderRadius: 6, columnWidth: '60%' } },
        dataLabels: { enabled: false },
        grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
        tooltip: { y: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
    }).render();
}

// Trend 12 Bulan
const trendData = @json($omzetBulanan);
new ApexCharts(document.querySelector('#chartTrend'), {
    chart: { type: 'area', height: 250, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
    series: [{ name: 'Omzet', data: trendData.map(d => d.omzet) }],
    xaxis: { categories: trendData.map(d => d.bulan), labels: { style: { colors: '#9ca3af', fontSize: '9px' }, rotate: -30 } },
    yaxis: { labels: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v), style: { colors: '#9ca3af', fontSize: '9px' } } },
    fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } },
    stroke: { curve: 'smooth', width: 2.5, colors: ['#14b8a6'] },
    colors: ['#14b8a6'],
    dataLabels: { enabled: false },
    grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
    tooltip: { y: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
}).render();

// Pie Pengeluaran
const pengeluaranData = @json($pengeluaranKategori);
if (pengeluaranData.length > 0) {
    new ApexCharts(document.querySelector('#chartPengeluaran'), {
        chart: { type: 'donut', height: 200, fontFamily: 'Inter, sans-serif' },
        series: pengeluaranData.map(d => parseFloat(d.total)),
        labels: pengeluaranData.map(d => d.kategori),
        colors: ['#f97316', '#14b8a6', '#fbbf24', '#6366f1', '#ec4899'],
        plotOptions: { pie: { donut: { size: '60%' } } },
        dataLabels: { enabled: false },
        legend: { position: 'bottom', fontSize: '11px' },
        tooltip: { y: { formatter: v => 'Rp ' + new Intl.NumberFormat('id-ID').format(v) } },
    }).render();
}
</script>
@endpush
