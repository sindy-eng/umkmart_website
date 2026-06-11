<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi', 'user_id', 'customer_id', 'promo_id',
        'subtotal', 'diskon', 'total', 'bayar', 'kembalian', 'metode_bayar', 'status', 'catatan',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'diskon' => 'decimal:2',
            'total' => 'decimal:2',
            'bayar' => 'decimal:2',
            'kembalian' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    public static function generateNomor(): string
    {
        $prefix = 'TRX-' . date('Ymd') . '-';
        $last = static::where('nomor_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')->first();
        $num = $last ? (int) substr($last->nomor_transaksi, -4) + 1 : 1;
        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}