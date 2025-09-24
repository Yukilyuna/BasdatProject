<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'price',
        'is_prescription_only',
        'stock',
        'description',
    ];

    protected $casts = [
        'is_prescription_only' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
