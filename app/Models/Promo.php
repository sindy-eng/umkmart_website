<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_promo', 'tipe_diskon', 'nilai_diskon',
        'tanggal_mulai', 'tanggal_selesai', 'aktif', 'deskripsi',
        'last_broadcast_at', 'broadcast_count',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'      => 'date',
            'tanggal_selesai'    => 'date',
            'nilai_diskon'       => 'decimal:2',
            'aktif'              => 'boolean',
            'last_broadcast_at'  => 'datetime',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now());
    }

    public function hitungDiskon(float $subtotal): float
    {
        if ($this->tipe_diskon === 'persen') {
            return $subtotal * ($this->nilai_diskon / 100);
        }
        return min($this->nilai_diskon, $subtotal);
    }
}
