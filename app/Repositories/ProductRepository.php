<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function store(
        string $name,
        ?string $description,
        int $category_id,
        float $price,
        float $mark_up,
        float $selling_price
    ) : ?Product
    {
        return Product::create([
            'name'          => $name,
            'description'   => $description,
            'category_id'   => $category_id,
            'price'         => $price,
            'mark_up'       => $category_id,
            'selling_price' => $selling_price,
        ]);
    }
}