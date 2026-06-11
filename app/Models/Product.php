<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk', 'kategori', 'harga', 'stok',
        'deskripsi', 'gambar_produk', 'aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'aktif' => 'boolean',
        ];
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeStokMenipis($query, $threshold = 10)
    {
        return $query->where('stok', '<', $threshold)->where('stok', '>', 0);
    }

    public function scopeHabis($query)
    {
        return $query->where('stok', 0);
    }
}
