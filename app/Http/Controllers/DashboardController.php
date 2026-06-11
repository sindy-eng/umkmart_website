<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->subDays(6)->startOfDay();

        // Stats hari ini
        $penjualanHariIni = Transaction::whereDate('created_at', $today)->where('status', 'selesai')->count();
        $omzetHariIni = Transaction::whereDate('created_at', $today)->where('status', 'selesai')->sum('total');
        $totalProduk = Product::where('aktif', 1)->count();
        $stokMenipis = Product::stokMenipis()->count();
        $totalPelanggan = Customer::count();

        // Grafik penjualan 7 hari
        $grafikData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $grafikData[] = [
                'tanggal' => $date->format('d M'),
                'omzet' => (float) Transaction::whereDate('created_at', $date)->where('status', 'selesai')->sum('total'),
                'jumlah' => Transaction::whereDate('created_at', $date)->where('status', 'selesai')->count(),
            ];
        }

        // Produk terlaris (top 5)
        $produkTerlaris = \App\Models\TransactionDetail::selectRaw('product_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_omzet')
            ->with('product')
            ->whereHas('transaction', fn($q) => $q->where('status', 'selesai'))
            ->groupBy('product_id')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Stok menipis produk
        $produkStokMenipis = Product::stokMenipis(10)->orderBy('stok')->limit(5)->get();

        // Transaksi terbaru
        $transaksiTerbaru = Transaction::with(['user', 'customer'])->latest()->limit(5)->get();

        return view('dashboard', compact(
            'penjualanHariIni', 'omzetHariIni', 'totalProduk',
            'stokMenipis', 'totalPelanggan', 'grafikData',
            'produkTerlaris', 'produkStokMenipis', 'transaksiTerbaru'
        ));
    }
}
