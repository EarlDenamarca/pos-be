<?php

namespace App\Services;

use App\Models\Sale;
use App\Repositories\SaleRepository;

class SaleService
{
    private SaleRepository $sale_repo;

    public function __construct( SaleRepository $sale_repo )
    {
        $this->sale_repo = $sale_repo;
    }

    public function storeSale(
        float $total,
        float $cash_tendered,
        float $change,
        array $purchase_list
    ) : Sale
    {
        return $this->sale_repo->store(
            $total,
            $cash_tendered,
            $change,
            $purchase_list
        );
    }
}
