<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medicine;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'medicine_id', 'qty', 'unit_price', 'subtotal',
    ];

    protected static function booted(): void
    {
        // stok berkurang setelah item dibuat
        static::created(function (OrderItem $item) {
            Medicine::whereKey($item->medicine_id)->decrement('stock', (int) $item->qty);
        });

        // (opsional) jika item dihapus, stok balik
        static::deleted(function (OrderItem $item) {
            Medicine::whereKey($item->medicine_id)->increment('stock', (int) $item->qty);
        });
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
