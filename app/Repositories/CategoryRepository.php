<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function find( int $id ) : Category
    {
        return Category::find( $id );
    }
}