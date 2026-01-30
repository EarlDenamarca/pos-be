<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SaleItem;

class SaleItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ( $i = 0; $i < 100; $i++ ) {
            SaleItem::create([
                'sale_id'       => 12,
                'product_id'    => 13,
                'name'          => 'Calla Powder',
                'description'   => $item['description'] ?? null,
                'price'         => 13.65,
                'selling_price' => 18.00,
                'quantity'      => 2,
                'sub_total'     => 36.00,
                'profit'        => 8.70
            ]);
        }
    }
}
