<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Contracts\Pagination\CursorPaginator;
use App\Repositories\SaleItemsRepository;
use App\Repositories\SaleRepository;

class SaleService
{
    private SaleRepository $sale_repo;
    private SaleItemsRepository $sale_items_repo;

    public function __construct(
        SaleRepository $sale_repo,
        SaleItemsRepository $sale_items_repo
    )
    {
        $this->sale_repo = $sale_repo;
        $this->sale_items_repo = $sale_items_repo;
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

    public function listSaleItems(
        int $limit,
        ?string $cursor,
        ?int $category_id,
        ?string $date,
        ?string $timezone
    ) : CursorPaginator
    {
        return $this->sale_items_repo->cursorPaginateSaleItems(
            $limit,
            $cursor,
            $category_id,
            $date,
            $timezone
        );
    }

    public function saleItemsTotals(
        ?int $category_id,
        ?string $date,
        ?string $timezone
    ) : array
    {
        return $this->sale_items_repo->totals($category_id, $date, $timezone);
    }
}
