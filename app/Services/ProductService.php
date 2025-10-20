<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    private ProductRepository $product_repo;

    public function __construct( ProductRepository $product_repo )
    {
        $this->product_repo = $product_repo;
    }

    public function storeProduct(
        string $name,
        ?string $description,
        int $category_id,
        float $price,
        float $mark_up,
        float $selling_price
    ) : Product
    {
        return $this->product_repo->store(
            $name,
            $description,
            $category_id,
            $price,
            $mark_up,
            $selling_price
        );
    }
}