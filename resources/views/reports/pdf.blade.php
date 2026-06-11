<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan UMKMART</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { background: #ea580c; color: white; padding: 20px; text-align: center; margin-bottom: 20px; }
        .header h1 { font-size: 24px; font-weight: bold; }
        .header p { font-size: 12px; opacity: 0.85; margin-top: 4px; }
        .section { margin: 0 20px 20px; }
        .section-title { font-size: 14px; font-weight: bold; color: #ea580c; border-bottom: 2px solid #ea580c; padding-bottom: 5px; margin-bottom: 10px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; padding: 0 20px; }
        .stat-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 12px; text-align: center; }
        .stat-box .value { font-size: 16px; font-weight: bold; color: #ea580c; }
        .stat-box .label { font-size: 10px; color: #6b7280; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th { background: #ea580c; color: white; padding: 8px 10px; text-align: left; }
        td { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; }
        tr:nth-child(even) td { background: #fff7ed; }
        .text-right { text-align: right; }
        .footer { margin: 20px; padding-top: 10px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 10px; color: #9ca3af; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 9999px; font-size: 10px; font-weight: bold; }
        .badge-green { background: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <div class="header">
        <h1>UMKMART</h1>
        <p>Laporan Keuangan — {{ \Carbon\Carbon::parse($bulan)->format('F Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    {{-- Ringkasan --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="value">Rp {{ number_format($totalOmzet ?? 0, 0, ',', '.') }}</div>
            <div class="label">Total Omzet</div>
        </div>
        <div class="stat-box">
            <div class="value">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</div>
            <div class="label">Total Pengeluaran</div>
        </div>
        <div class="stat-box">
            <div class="value">Rp {{ number_format(($totalOmzet ?? 0) - ($totalPengeluaran ?? 0), 0, ',', '.') }}</div>
            <div class="label">Laba Bersih</div>
        </div>
    </div>

    {{-- Tabel Omzet Harian --}}
    <div class="section">
        <div class="section-title">Omzet Harian</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th class="text-right">Jumlah Transaksi</th>
                    <th class="text-right">Omzet</th>
                </tr>
            </thead>
            <tbody>
                @forelse($omzetHarian ?? [] as $data)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
                    <td class="text-right">{{ $data->jumlah }} transaksi</td>
                    <td class="text-right">Rp {{ number_format($data->omzet, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center; color:#9ca3af;">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Produk Terlaris --}}
    <div class="section">
        <div class="section-title">Produk Terlaris</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th class="text-right">Terjual</th>
                    <th class="text-right">Omzet</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produkTerlaris ?? [] as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product->nama_produk ?? '-' }}</td>
                    <td class="text-right">{{ $item->total_terjual }} pcs</td>
                    <td class="text-right">Rp {{ number_format($item->total_omzet, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; color:#9ca3af;">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem UMKMART &bull; {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>