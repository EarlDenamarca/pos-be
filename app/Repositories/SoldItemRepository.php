<?php

namespace App\Repositories;

use App\Models\SoldItem;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\CursorPaginator;

class SoldItemRepository
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
            ->select('sold_items.*', 'categories.name as category');

        return $query->orderBy('sold_items.id')
            ->cursorPaginate(
                $limit,
                ['sold_items.*', 'categories.name as category'],
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
            ->selectRaw('SUM(sold_items.profit) as profit_sum, SUM(sold_items.sub_total) as sub_total_sum')
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
        $query = SoldItem::query()
            ->leftJoin('products', 'products.id', '=', 'sold_items.product_id')
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

            $query->whereBetween('sold_items.created_at', [$start, $end]);
        }

        return $query;
    }
}
