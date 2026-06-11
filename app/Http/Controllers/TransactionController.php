<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\LoyaltyPoint;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function pos()
    {
        $products  = Product::aktif()->where('stok', '>', 0)->get();
        $customers = Customer::all();
        $promos    = Promo::aktif()->get();

        return response()
            ->view('pos.index', compact('products', 'customers', 'promos'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma',  'no-cache')
            ->header('Expires', '0');
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'customer'])->orderBy('created_at', 'desc')->orderBy('id', 'desc');

        if ($request->search) {
            $query->where('nomor_transaksi', 'like', "%{$request->search}%");
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->tanggal_mulai) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        $transactions = $query->paginate(15);

        // Query dasar untuk statistik — ikut filter tanggal jika ada
        $statsQuery = Transaction::query();
        if ($request->tanggal_mulai) {
            $statsQuery->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $statsQuery->whereDate('created_at', '<=', $request->tanggal_selesai);
        }

        // Hitung dari seluruh DB (bukan hanya halaman ini), ikut filter tanggal
        $totalOmzetKeseluruhan = (clone $statsQuery)->where('status', 'selesai')->sum('total');
        $totalSelesai          = (clone $statsQuery)->where('status', 'selesai')->count();
        $totalDibatalkan       = (clone $statsQuery)->where('status', 'batal')->count();

        return view('transactions.index', compact(
            'transactions',
            'totalOmzetKeseluruhan',
            'totalSelesai',
            'totalDibatalkan'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['details.product', 'customer', 'user', 'promo']);
        return view('transactions.show', compact('transaction'));
    }

    public function struk(Transaction $transaction)
    {
        $transaction->load(['details.product', 'customer', 'user', 'promo']);
        return view('transactions.struk', compact('transaction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'bayar' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $items = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$product->nama_produk} tidak mencukupi!");
                }
                $sub = $product->harga * $item['jumlah'];
                $subtotal += $sub;
                $items[] = ['product' => $product, 'jumlah' => $item['jumlah'], 'harga' => $product->harga, 'sub' => $sub];
            }

            $diskon = 0;
            $promo = null;
            if ($request->promo_id) {
                $promo = Promo::find($request->promo_id);
                if ($promo) {
                    $diskon = $promo->hitungDiskon($subtotal);
                }
            }

            // Tambah diskon manual
            $diskonManual = max(0, (int) $request->diskon_manual);
            $diskon = $diskon + $diskonManual;
            if ($diskon > $subtotal) $diskon = $subtotal;

            $total = $subtotal - $diskon;
            $kembalian = $request->bayar - $total;

            if ($kembalian < 0) {
                throw new \Exception('Pembayaran kurang!');
            }

            $trx = Transaction::create([
                'nomor_transaksi' => Transaction::generateNomor(),
                'user_id'         => auth()->id(),
                'customer_id'     => $request->customer_id ?: null,
                'promo_id'        => $promo?->id,
                'subtotal'        => $subtotal,
                'diskon'          => $diskon,
                'total'           => $total,
                'bayar'           => $request->bayar,
                'kembalian'       => $kembalian,
                'metode_bayar'    => $request->metode_bayar ?? 'tunai',
                'status'          => 'selesai',
                'catatan'         => $request->catatan,
            ]);

            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $item['product']->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['sub'],
                ]);
                $item['product']->decrement('stok', $item['jumlah']);
            }

            // Loyalty points
            if ($request->customer_id) {
                $customer = Customer::find($request->customer_id);
                $poin = (int) ($total / 10000);
                if ($poin > 0 && $customer) {
                    LoyaltyPoint::create([
                        'customer_id' => $customer->id,
                        'transaction_id' => $trx->id,
                        'poin' => $poin,
                        'keterangan' => 'Poin dari transaksi ' . $trx->nomor_transaksi,
                    ]);
                    $customer->increment('total_poin', $poin);
                }
            }

            DB::commit();

            return redirect()->route('transactions.struk', $trx)->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->update(['status' => 'batal']);
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dibatalkan!');
    }
}