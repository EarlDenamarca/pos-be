<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialProduct extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'selling_price'
    ];
}
