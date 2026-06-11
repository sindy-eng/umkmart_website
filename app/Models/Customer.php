<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'nomor_wa', 'alamat', 'total_poin', 'aktif'];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    public function getTotalTransaksiAttribute()
    {
        return $this->transactions()->where('status', 'selesai')->count();
    }

    public function getTotalBelanjaAttribute()
    {
        return $this->transactions()->where('status', 'selesai')->sum('total');
    }

    public function scopeAktif($query)
    {
        return $query;
    }
}
