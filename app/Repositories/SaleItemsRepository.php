<?php

namespace App\Repositories;

use App\Models\SaleItem;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\CursorPaginator;

class SaleItemsRepository
{
    public function cursorPaginateSaleItems(
        int $limit,
        ?string $cursor,
        ?int $category_id,
        ?string $date,
        ?string $timezone
    ) : CursorPaginator
    {
        $query = $this->buildBaseQuery($category_id, $date, $timezone)
            ->select('sale_items.*', 'categories.name as category');

        return $query->orderBy('sale_items.id')
            ->cursorPaginate(
                $limit,
                ['sale_items.*', 'categories.name as category'],
                'cursor',
                $cursor
            );
    }

    public function totals(
        ?int $category_id,
        ?string $date,
        ?string $timezone
    ) : array
    {
        $totals = $this->buildBaseQuery($category_id, $date, $timezone)
            ->selectRaw('SUM(sale_items.profit) as profit_sum, SUM(sale_items.sub_total) as sub_total_sum')
            ->first();

        return [
            'profit_sum' => (float) ($totals->profit_sum ?? 0),
            'sub_total_sum' => (float) ($totals->sub_total_sum ?? 0),
        ];
    }

    private function buildBaseQuery(
        ?int $category_id,
        ?string $date,
        ?string $timezone
    )
    {
        $query = SaleItem::query()
            ->leftJoin('products', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id');

        if ( $category_id !== null ) {
            $query->where('products.category_id', $category_id);
        }

        if ( $date !== null && $date !== '' ) {
            $query_timezone = $timezone ?? config('app.timezone', 'UTC');
            $storage_timezone = config('app.timezone', 'UTC');

            $start = Carbon::createFromFormat('Y-m-d', $date, $query_timezone)
                ->startOfDay()
                ->setTimezone($storage_timezone);
            $end = Carbon::createFromFormat('Y-m-d', $date, $query_timezone)
                ->endOfDay()
                ->setTimezone($storage_timezone);

            $query->whereBetween('sale_items.created_at', [$start, $end]);
        }

        return $query;
    }
}
