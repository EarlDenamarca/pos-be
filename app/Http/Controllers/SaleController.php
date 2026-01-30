<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;

use Carbon\Carbon;

class SaleController extends Controller
{
    private SaleService $sale_service;

    public function __construct( SaleService $sale_service )
    {
        $this->sale_service = $sale_service;
    }

    /**
     * Store a newly created sale and its line items in storage.
     *
     * @param App\Http\Requests\SaleRequest $request:
     * - total (decimal, required)
     * - cash_tendered (decimal, required)
     * - change (decimal, required)
     * - purchase_list (array, required)
     *   - id (integer, required; product id)
     *   - name (string, required)
     *   - description (string, optional)
     *   - selling_price (decimal, required)
     *   - quantity (integer, required)
     *   - sub_total (decimal, required)
     */
    public function store( SaleRequest $request ) : JsonResponse
    {
        $sale = $this->sale_service->storeSale(
            $request->total,
            $request->cash_tendered,
            $request->change,
            $request->purchase_list
        );

        return response()->json([
            'message' => 'Sale successfully saved.',
            'sale_id' => $sale->id,
        ], 200);
    }

    /**
     * Display a listing of sale items.
     *
     * @param Illuminate\Http\Request $request
     *
     * @queryParam cursor    string  - pagination cursor
     * @queryParam limit     integer - number of results per page
     * @queryParam category  integer - product category id
     * @queryParam date      string  - sale_items created date (YYYY-MM-DD)
     */
    public function index( Request $request ) : JsonResponse
    {
        $limit       = $request->has('limit') ? $request->limit : 20;
        $cursor      = $request->query('cursor');
        $category_id = $request->has('category') ? (int) $request->category : null;
        $date        = $request->query('date');

        if ( $date !== null && $date !== '' ) {
            $date = Carbon::createFromFormat( 'Y-m-d', $date )->format('Y-m-d');
        }

        $items = $this->sale_service->listSaleItems(
            $limit,
            $cursor,
            $category_id,
            $date
        );
        $totals = $this->sale_service->saleItemsTotals($category_id, $date);

        return response()->json([
            'items' => $items,
            'totals' => $totals,
        ], 200);
    }
}
