<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;

class SaleRepository
{
    public function store(
        float $total,
        float $cash_tendered,
        float $change,
        array $purchase_list
    ) : Sale
    {
        return DB::transaction(function () use ($total, $cash_tendered, $change, $purchase_list) {
            $sale = Sale::create([
                'total'         => $total,
                'cash_tendered' => $cash_tendered,
                'change'        => $change,
            ]);

            foreach ($purchase_list as $item) {
                $original_price         = Product::find($item['id'])->price;
                $total_orignal_price    = $original_price * $item['quantity'];
                $profit                 = $item['sub_total'] - $total_orignal_price;

                SaleItem::create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $item['id'],
                    'name'          => $item['name'],
                    'description'   => $item['description'] ?? null,
                    'price'         => $original_price,
                    'selling_price' => $item['selling_price'],
                    'quantity'      => $item['quantity'],
                    'sub_total'     => $item['sub_total'],
                    'profit'        => $profit
                ]);
            }

            return $sale;
        });
    }
}
