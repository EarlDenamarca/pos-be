<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'total',
        'cash_tendered',
        'change',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SoldItem::class);
    }
}
