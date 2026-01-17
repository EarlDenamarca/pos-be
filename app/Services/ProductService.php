<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    private ProductRepository   $product_repo;
    private CategoryRepository  $category_repo;

    public function __construct( 
        ProductRepository   $product_repo,
        CategoryRepository  $category_repo
    )
    {
        $this->product_repo     = $product_repo;
        $this->category_repo    = $category_repo;
    }

    public function listProducts(
        int $page_number,
        int $limit,
        ?string $query
    ) : LengthAwarePaginator
    {
        $products = $this->product_repo->paginate($query, $limit, $page_number);

        foreach ( $products as $product ) {
            $category           = $this->category_repo->find( $product->category_id );
            $product->category  = $category->name;
        }

        return $products;
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
