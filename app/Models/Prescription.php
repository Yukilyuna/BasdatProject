<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = ['order_id','user_id','status','note','attachments'];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
