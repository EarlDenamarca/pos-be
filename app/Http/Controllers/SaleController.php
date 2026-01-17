<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;

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
}
