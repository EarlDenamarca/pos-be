<?php

namespace App\Services;

use App\Models\SpecialProduct;
use App\Repositories\SpecialProductRepository;

class SpecialProductService
{
    private SpecialProductRepository $special_product_repository;

    public function __construct( SpecialProductRepository $special_product_repository )
    {
        $this->special_product_repository = $special_product_repository;
    }

    public function storeSpecialProduct( int $product_id, float $quantity, float $selling_price ) : SpecialProduct
    {
        return $this->special_product_repository->store(
            $product_id,
            $quantity,
            $selling_price
        );
    }
}