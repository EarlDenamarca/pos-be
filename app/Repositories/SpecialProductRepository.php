<?php

namespace App\Repositories;

use App\Models\SpecialProduct;

class SpecialProductRepository
{
    public function store( int $product_id, float $quantity, float $selling_price ) : SpecialProduct
    {
        return SpecialProduct::create([
            'product_id'    => $product_id,
            'quantity'      => $quantity,
            'selling_price' => $selling_price
        ]);
    }
}