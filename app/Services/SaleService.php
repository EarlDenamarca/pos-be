<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Contracts\Pagination\CursorPaginator;
use App\Repositories\SoldItemRepository;
use App\Repositories\SaleRepository;

class SaleService
{
    private SaleRepository $sale_repo;
    private SoldItemRepository $sold_item_repo;

    public function __construct(
        SaleRepository $sale_repo,
        SoldItemRepository $sold_item_repo
    )
    {
        $this->sale_repo = $sale_repo;
        $this->sold_item_repo = $sold_item_repo;
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
        return $this->sold_item_repo->cursorPaginateSaleItems(
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
        return $this->sold_item_repo->totals($category_id, $date, $timezone);
    }
}
