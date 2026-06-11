<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Exports\ReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));

        // Omzet bulanan per hari
        $omzetHarian = Transaction::selectRaw('DATE(created_at) as tanggal, SUM(total) as omzet, COUNT(*) as jumlah')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('status', 'selesai')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Total omzet bulan ini
        $totalOmzet = $omzetHarian->sum('omzet');
        $totalTransaksi = $omzetHarian->sum('jumlah');

        // Total pengeluaran bulan ini
        $totalPengeluaran = Expense::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->sum('jumlah');

        // Laba bersih (sederhana)
        $labaBersih = $totalOmzet - $totalPengeluaran;

        // Omzet 12 bulan terakhir
        $omzetBulanan = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $omzetBulanan[] = [
                'bulan' => $date->format('M Y'),
                'omzet' => (float) Transaction::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->where('status', 'selesai')
                    ->sum('total'),
            ];
        }

        // Produk terlaris bulan ini
        $produkTerlaris = TransactionDetail::selectRaw('product_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_omzet')
            ->with('product')
            ->whereHas('transaction', fn($q) => $q->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('status', 'selesai'))
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        // Pengeluaran per kategori
        $pengeluaranKategori = Expense::selectRaw('kategori, SUM(jumlah) as total')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        return view('reports.index', compact(
            'bulan', 'omzetHarian', 'totalOmzet', 'totalTransaksi',
            'totalPengeluaran', 'labaBersih', 'omzetBulanan',
            'produkTerlaris', 'pengeluaranKategori'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        $year = date('Y', strtotime($bulan));
        $month = date('m', strtotime($bulan));

        $data = $this->getReportData($bulan, $year, $month);

        $pdf = Pdf::loadView('reports.pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->download('laporan-' . $bulan . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');
        return Excel::download(new ReportExport($bulan), 'laporan-' . $bulan . '.xlsx');
    }

    private function getReportData($bulan, $year, $month): array
    {
        $omzetHarian = Transaction::selectRaw('DATE(created_at) as tanggal, SUM(total) as omzet, COUNT(*) as jumlah')
            ->whereMonth('created_at', $month)->whereYear('created_at', $year)
            ->where('status', 'selesai')->groupBy('tanggal')->orderBy('tanggal')->get();

        $totalOmzet = $omzetHarian->sum('omzet');
        $totalPengeluaran = Expense::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->sum('jumlah');

        $produkTerlaris = TransactionDetail::selectRaw('product_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_omzet')
            ->with('product')
            ->whereHas('transaction', fn($q) => $q->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('status', 'selesai'))
            ->groupBy('product_id')->orderByDesc('total_terjual')->limit(10)->get();

        return compact('bulan', 'omzetHarian', 'totalOmzet', 'totalPengeluaran', 'produkTerlaris');
    }
}
