<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadProductImages extends Command
{
    protected $signature   = 'products:download-images';
    protected $description = 'Download gambar produk sembako dari Unsplash dan simpan ke storage';

    protected array $images = [
        'beras-premium.jpg'   => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400',
        'beras-medium.jpg'    => 'https://images.unsplash.com/photo-1536304993881-ff86e0c9c5c3?w=400',
        'minyak-goreng-1l.jpg'=> 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400',
        'minyak-goreng-2l.jpg'=> 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400',
        'gula-pasir.jpg'      => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=400',
        'tepung-terigu.jpg'   => 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400',
        'telur-ayam.jpg'      => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=400',
        'garam-halus.jpg'     => 'https://images.unsplash.com/photo-1518110925495-5fe2fda0442c?w=400',
        'kecap-manis.jpg'     => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400',
        'mie-instan.jpg'      => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400',
        'sabun-mandi.jpg'     => 'https://images.unsplash.com/photo-1584515933487-779824d29309?w=400',
        'shampo-sachet.jpg'   => 'https://images.unsplash.com/photo-1585232350789-6034f64f6936?w=400',
        'deterjen.jpg'        => 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=400',
        'kopi-sachet.jpg'     => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=400',
        'susu-kental.jpg'     => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=400',
    ];

    public function handle(): int
    {
        // Pastikan direktori ada
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
            $this->info('✓ Folder products/ dibuat');
        }

        $this->info('⬇  Mulai download ' . count($this->images) . ' gambar produk...');
        $this->newLine();

        $berhasil = 0;
        $gagal    = 0;

        foreach ($this->images as $filename => $url) {
            $path = 'products/' . $filename;

            // Skip jika sudah ada
            if (Storage::disk('public')->exists($path)) {
                $this->line("  <fg=yellow>⊙</> <fg=gray>Sudah ada:</> {$filename}");
                $berhasil++;
                continue;
            }

            try {
                $this->line("  <fg=cyan>↓</> Downloading: {$filename}");

                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (compatible; UMKMART/1.0)',
                        'Accept'     => 'image/webp,image/apng,image/*,*/*;q=0.8',
                    ])
                    ->get($url);

                if ($response->successful() && strlen($response->body()) > 1000) {
                    Storage::disk('public')->put($path, $response->body());
                    $size = round(strlen($response->body()) / 1024, 1);
                    $this->line("  <fg=green>✓</> Tersimpan: {$filename} ({$size} KB)");
                    $berhasil++;
                } else {
                    $this->line("  <fg=red>✗</> Gagal (HTTP {$response->status()}): {$filename}");
                    $gagal++;
                }
            } catch (\Exception $e) {
                $this->line("  <fg=red>✗</> Error: {$filename} — " . $e->getMessage());
                $gagal++;
            }

            // Jeda kecil agar tidak rate-limited
            usleep(300000); // 300ms
        }

        $this->newLine();
        $this->info("=================================");
        $this->info("✓ Berhasil : {$berhasil}");
        if ($gagal > 0) {
            $this->warn("✗ Gagal    : {$gagal}");
        }
        $this->info("=================================");

        return $gagal === 0 ? self::SUCCESS : self::FAILURE;
    }
}
