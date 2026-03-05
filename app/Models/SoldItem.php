<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoldItem extends Model
{
    protected $table = 'sold_items';

    protected $fillable = [
        'sale_id',
        'product_id',
        'name',
        'description',
        'price',
        'selling_price',
        'quantity',
        'sub_total',
        'profit'
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
