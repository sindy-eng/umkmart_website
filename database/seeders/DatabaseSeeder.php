<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\LoyaltyPoint;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== USERS ====================
        $admin = User::create([
            'name'     => 'Admin UMKMART',
            'email'    => 'admin@umkmart.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $kasir = User::create([
            'name'     => 'Kasir UMKMART',
            'email'    => 'kasir@umkmart.com',
            'password' => Hash::make('password'),
            'role'     => 'kasir',
        ]);

        // ==================== PRODUK SEMBAKO ====================
        // Mapping gambar produk (akan diisi setelah download)
        $gambarMap = [
            'Beras Premium 5kg'  => 'products/beras-premium.jpg',
            'Beras Medium 5kg'   => 'products/beras-medium.jpg',
            'Telur Ayam 1kg'     => 'products/telur-ayam.jpg',
            'Gula Pasir 1kg'     => 'products/gula-pasir.jpg',
            'Tepung Terigu 1kg'  => 'products/tepung-terigu.jpg',
            'Garam Halus 500gr'  => 'products/garam-halus.jpg',
            'Kecap Manis 135ml'  => 'products/kecap-manis.jpg',
            'Minyak Goreng 1L'   => 'products/minyak-goreng-1l.jpg',
            'Minyak Goreng 2L'   => 'products/minyak-goreng-2l.jpg',
            'Mie Instan'         => 'products/mie-instan.jpg',
            'Kopi Sachet'        => 'products/kopi-sachet.jpg',
            'Susu Kental Manis'  => 'products/susu-kental.jpg',
            'Sabun Mandi'        => 'products/sabun-mandi.jpg',
            'Shampo Sachet'      => 'products/shampo-sachet.jpg',
            'Deterjen 800gr'     => 'products/deterjen.jpg',
        ];

        $products = [
            // Beras & Sembako
            [
                'nama_produk'  => 'Beras Premium 5kg',
                'kategori'     => 'Beras & Sembako',
                'harga'        => 75000,
                'stok'         => 100,
                'deskripsi'    => 'Beras premium pulen berkualitas tinggi kemasan 5kg',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Beras Premium 5kg'],
            ],
            [
                'nama_produk'  => 'Beras Medium 5kg',
                'kategori'     => 'Beras & Sembako',
                'harga'        => 60000,
                'stok'         => 150,
                'deskripsi'    => 'Beras medium kemasan 5kg, cocok untuk keluarga',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Beras Medium 5kg'],
            ],
            [
                'nama_produk'  => 'Telur Ayam 1kg',
                'kategori'     => 'Beras & Sembako',
                'harga'        => 28000,
                'stok'         => 50,
                'deskripsi'    => 'Telur ayam segar grade A, per kilogram',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Telur Ayam 1kg'],
            ],
            [
                'nama_produk'  => 'Gula Pasir 1kg',
                'kategori'     => 'Bumbu Dapur',
                'harga'        => 16000,
                'stok'         => 120,
                'deskripsi'    => 'Gula pasir putih halus 1kg',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Gula Pasir 1kg'],
            ],
            [
                'nama_produk'  => 'Tepung Terigu 1kg',
                'kategori'     => 'Bumbu Dapur',
                'harga'        => 12000,
                'stok'         => 90,
                'deskripsi'    => 'Tepung terigu serbaguna kemasan 1kg',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Tepung Terigu 1kg'],
            ],
            [
                'nama_produk'  => 'Garam Halus 500gr',
                'kategori'     => 'Bumbu Dapur',
                'harga'        => 5000,
                'stok'         => 200,
                'deskripsi'    => 'Garam halus beryodium 500 gram',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Garam Halus 500gr'],
            ],
            [
                'nama_produk'  => 'Kecap Manis 135ml',
                'kategori'     => 'Bumbu Dapur',
                'harga'        => 8000,
                'stok'         => 70,
                'deskripsi'    => 'Kecap manis botol 135ml',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Kecap Manis 135ml'],
            ],
            // Minyak & Lemak
            [
                'nama_produk'  => 'Minyak Goreng 1L',
                'kategori'     => 'Minyak & Lemak',
                'harga'        => 18000,
                'stok'         => 80,
                'deskripsi'    => 'Minyak goreng kemasan 1 liter',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Minyak Goreng 1L'],
            ],
            [
                'nama_produk'  => 'Minyak Goreng 2L',
                'kategori'     => 'Minyak & Lemak',
                'harga'        => 34000,
                'stok'         => 60,
                'deskripsi'    => 'Minyak goreng kemasan 2 liter, lebih hemat',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Minyak Goreng 2L'],
            ],
            // Sembako lain
            [
                'nama_produk'  => 'Mie Instan',
                'kategori'     => 'Beras & Sembako',
                'harga'        => 3500,
                'stok'         => 500,
                'deskripsi'    => 'Mie instan berbagai rasa, per bungkus',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Mie Instan'],
            ],
            [
                'nama_produk'  => 'Kopi Sachet',
                'kategori'     => 'Minuman',
                'harga'        => 2500,
                'stok'         => 400,
                'deskripsi'    => 'Kopi sachet 3-in-1, per bungkus',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Kopi Sachet'],
            ],
            [
                'nama_produk'  => 'Susu Kental Manis',
                'kategori'     => 'Minuman',
                'harga'        => 12000,
                'stok'         => 80,
                'deskripsi'    => 'Susu kental manis kaleng 385gr',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Susu Kental Manis'],
            ],
            // Kebersihan
            [
                'nama_produk'  => 'Sabun Mandi',
                'kategori'     => 'Kebersihan',
                'harga'        => 5000,
                'stok'         => 150,
                'deskripsi'    => 'Sabun mandi batang 85gr',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Sabun Mandi'],
            ],
            [
                'nama_produk'  => 'Shampo Sachet',
                'kategori'     => 'Kebersihan',
                'harga'        => 2000,
                'stok'         => 300,
                'deskripsi'    => 'Shampo sachet 10ml, berbagai merek',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Shampo Sachet'],
            ],
            [
                'nama_produk'  => 'Deterjen 800gr',
                'kategori'     => 'Kebersihan',
                'harga'        => 22000,
                'stok'         => 60,
                'deskripsi'    => 'Deterjen bubuk 800 gram',
                'aktif'        => true,
                'gambar_produk'=> $gambarMap['Deterjen 800gr'],
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        // ==================== PELANGGAN ====================
        $customers = [
            ['nama' => 'Ibu Sari Dewi',    'nomor_wa' => '081234567890', 'alamat' => 'Jl. Mawar No. 12, RT 03/05',     'total_poin' => 250],
            ['nama' => 'Pak Budi Hartono', 'nomor_wa' => '082345678901', 'alamat' => 'Jl. Melati No. 7, Blok B',       'total_poin' => 180],
            ['nama' => 'Ibu Aminah',       'nomor_wa' => '083456789012', 'alamat' => 'Gang Kenanga No. 3',             'total_poin' => 95],
            ['nama' => 'Pak Agus Salim',   'nomor_wa' => '084567890123', 'alamat' => 'Jl. Cempaka No. 21',            'total_poin' => 410],
            ['nama' => 'Ibu Rina Susanti', 'nomor_wa' => '085678901234', 'alamat' => 'Perumahan Griya Asri Blok C-5', 'total_poin' => 0],
            ['nama' => 'Pak Hasan',        'nomor_wa' => '086789012345', 'alamat' => 'Jl. Pahlawan No. 8',            'total_poin' => 130],
        ];

        $customerModels = [];
        foreach ($customers as $c) {
            $customerModels[] = Customer::create($c);
        }

        // ==================== PROMO ====================
        $promo1 = Promo::create([
            'nama_promo'      => 'Promo Belanja Hemat 10%',
            'tipe_diskon'     => 'persen',
            'nilai_diskon'    => 10,
            'tanggal_mulai'   => now()->startOfMonth(),
            'tanggal_selesai' => now()->endOfMonth(),
            'aktif'           => true,
            'deskripsi'       => 'Diskon 10% untuk semua pembelian minimal Rp 50.000',
        ]);

        Promo::create([
            'nama_promo'      => 'Promo Pelanggan Setia',
            'tipe_diskon'     => 'nominal',
            'nilai_diskon'    => 5000,
            'tanggal_mulai'   => now()->subDays(10),
            'tanggal_selesai' => now()->addDays(20),
            'aktif'           => true,
            'deskripsi'       => 'Potongan Rp 5.000 untuk pelanggan dengan poin lebih dari 100',
        ]);

        Promo::create([
            'nama_promo'      => 'Flash Sale Beras Murah',
            'tipe_diskon'     => 'persen',
            'nilai_diskon'    => 15,
            'tanggal_mulai'   => now()->subMonth(),
            'tanggal_selesai' => now()->subDays(5),
            'aktif'           => false,
            'deskripsi'       => 'Flash sale khusus beras dan sembako 15% off',
        ]);

        Promo::create([
            'nama_promo'      => 'Promo Gajian Akhir Bulan',
            'tipe_diskon'     => 'nominal',
            'nilai_diskon'    => 10000,
            'tanggal_mulai'   => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(10),
            'aktif'           => true,
            'deskripsi'       => 'Potongan Rp 10.000 setiap akhir bulan untuk semua pelanggan',
        ]);

        // ==================== TRANSAKSI (7 hari terakhir) ====================
        $allProducts = Product::all();
        for ($i = 6; $i >= 0; $i--) {
            $count = rand(4, 10);
            for ($j = 0; $j < $count; $j++) {
                $customer    = rand(0, 1) ? $customerModels[array_rand($customerModels)] : null;
                $numItems    = rand(1, 4);
                $subtotal    = 0;
                $items       = [];

                for ($k = 0; $k < $numItems; $k++) {
                    $product  = $allProducts->random();
                    $jumlah   = rand(1, 5);
                    $harga    = $product->harga;
                    $sub      = $harga * $jumlah;
                    $subtotal += $sub;
                    $items[]  = [
                        'product' => $product,
                        'jumlah'  => $jumlah,
                        'harga'   => $harga,
                        'sub'     => $sub,
                    ];
                }

                $diskon    = 0;
                $promoUsed = null;
                if (rand(0, 3) === 0) {
                    $promoUsed = $promo1;
                    $diskon    = (int) ($subtotal * 0.10);
                }

                $total      = $subtotal - $diskon;
                $kembalian  = rand(0, 2) * 1000;
                $bayar      = $total + $kembalian;

                $trx = Transaction::create([
                    'nomor_transaksi' => Transaction::generateNomor(),
                    'user_id'         => rand(0, 1) ? $admin->id : $kasir->id,
                    'customer_id'     => $customer?->id,
                    'promo_id'        => $promoUsed?->id,
                    'subtotal'        => $subtotal,
                    'diskon'          => $diskon,
                    'total'           => $total,
                    'bayar'           => $bayar,
                    'kembalian'       => $kembalian,
                    'metode_bayar'    => ['tunai', 'transfer', 'qris'][rand(0, 2)],
                    'status'          => rand(0, 9) < 9 ? 'selesai' : 'batal',
                    'created_at'      => now()->subDays($i)->addHours(rand(7, 20))->addMinutes(rand(0, 59)),
                    'updated_at'      => now()->subDays($i)->addHours(rand(7, 20))->addMinutes(rand(0, 59)),
                ]);

                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $trx->id,
                        'product_id'     => $item['product']->id,
                        'jumlah'         => $item['jumlah'],
                        'harga_satuan'   => $item['harga'],
                        'subtotal'       => $item['sub'],
                    ]);
                }

                // Loyalty points untuk pelanggan
                if ($customer && $trx->status === 'selesai') {
                    $poin = (int) ($total / 10000);
                    if ($poin > 0) {
                        LoyaltyPoint::create([
                            'customer_id'    => $customer->id,
                            'transaction_id' => $trx->id,
                            'poin'           => $poin,
                            'keterangan'     => 'Poin dari transaksi ' . $trx->nomor_transaksi,
                        ]);
                    }
                }
            }
        }

        // ==================== PENGELUARAN (30 hari terakhir) ====================
        $kategoriExpenses = [
            'Pembelian Stok',
            'Gaji Karyawan',
            'Listrik & Air',
            'Sewa Tempat',
            'Operasional',
            'Transportasi',
        ];

        for ($i = 29; $i >= 0; $i--) {
            if (rand(0, 2) === 0) {
                Expense::create([
                    'user_id'    => $admin->id,
                    'kategori'   => $kategoriExpenses[array_rand($kategoriExpenses)],
                    'jumlah'     => rand(50, 800) * 1000,
                    'keterangan' => 'Pengeluaran operasional toko',
                    'tanggal'    => now()->subDays($i)->toDateString(),
                ]);
            }
        }
    }
}
