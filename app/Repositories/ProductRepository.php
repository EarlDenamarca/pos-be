<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function paginate(
        ?string $query,
        int $limit,
        int $page_number
    ) : LengthAwarePaginator
    {
        $builder = Product::query();

        if ( $query !== null && $query !== '' ) {
            $builder->where(function ( $query_builder ) use ( $query ) {
                $query_builder->where('name', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%');
            });
        }

        return $builder->paginate($limit, ['*'], 'page', $page_number);
    }

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
            'mark_up'       => $mark_up,
            'selling_price' => $selling_price,
        ]);
    }
}
