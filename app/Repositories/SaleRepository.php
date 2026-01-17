<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
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
                SaleItem::create([
                    'sale_id'       => $sale->id,
                    'product_id'    => $item['id'],
                    'name'          => $item['name'],
                    'description'   => $item['description'] ?? null,
                    'selling_price' => $item['selling_price'],
                    'quantity'      => $item['quantity'],
                    'sub_total'     => $item['sub_total'],
                ]);
            }

            return $sale;
        });
    }
}
