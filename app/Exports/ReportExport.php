<?php

namespace App\Exports;

use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    public function __construct(private string $bulan) {}

    public function sheets(): array
    {
        return [
            new OmzetSheet($this->bulan),
            new PengeluaranSheet($this->bulan),
            new ProdukSheet($this->bulan),
        ];
    }
}

class OmzetSheet implements FromArray, WithHeadings, WithTitle
{
    public function __construct(private string $bulan) {}

    public function title(): string { return 'Omzet Harian'; }

    public function headings(): array
    {
        return ['Tanggal', 'Jumlah Transaksi', 'Total Omzet (Rp)'];
    }

    public function array(): array
    {
        $year = date('Y', strtotime($this->bulan));
        $month = date('m', strtotime($this->bulan));

        return Transaction::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah, SUM(total) as omzet')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('status', 'selesai')->groupBy('tanggal')->orderBy('tanggal')
            ->get()->map(fn($r) => [$r->tanggal, $r->jumlah, $r->omzet])->toArray();
    }
}

class PengeluaranSheet implements FromArray, WithHeadings, WithTitle
{
    public function __construct(private string $bulan) {}

    public function title(): string { return 'Pengeluaran'; }

    public function headings(): array
    {
        return ['Tanggal', 'Kategori', 'Jumlah (Rp)', 'Keterangan'];
    }

    public function array(): array
    {
        $year = date('Y', strtotime($this->bulan));
        $month = date('m', strtotime($this->bulan));

        return Expense::whereMonth('tanggal', $month)->whereYear('tanggal', $year)
            ->orderBy('tanggal')
            ->get()->map(fn($r) => [$r->tanggal->format('Y-m-d'), $r->kategori, $r->jumlah, $r->keterangan])->toArray();
    }
}

class ProdukSheet implements FromArray, WithHeadings, WithTitle
{
    public function __construct(private string $bulan) {}

    public function title(): string { return 'Produk Terlaris'; }

    public function headings(): array
    {
        return ['Produk', 'Kategori', 'Total Terjual', 'Total Omzet (Rp)'];
    }

    public function array(): array
    {
        $year = date('Y', strtotime($this->bulan));
        $month = date('m', strtotime($this->bulan));

        return TransactionDetail::selectRaw('product_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_omzet')
            ->with('product')
            ->whereHas('transaction', fn($q) => $q->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('status', 'selesai'))
            ->groupBy('product_id')->orderByDesc('total_terjual')->limit(20)->get()
            ->map(fn($r) => [$r->product->nama_produk ?? '-', $r->product->kategori ?? '-', $r->total_terjual, $r->total_omzet])
            ->toArray();
    }
}
