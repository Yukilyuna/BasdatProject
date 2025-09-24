<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id','status','total_amount',
        'recipient_name','recipient_phone','shipping_address',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function items(): HasMany { return $this->hasMany(OrderItem::class); }

    public function prescription(): HasOne { return $this->hasOne(Prescription::class); }

    public function paymentProofs(): HasMany { return $this->hasMany(PaymentProof::class); }

    public function shipment(): HasOne { return $this->hasOne(Shipment::class); }
}
