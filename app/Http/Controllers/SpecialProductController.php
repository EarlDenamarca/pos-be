<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpecialProductService;

class SpecialProductController extends Controller
{
    private SpecialProductService $special_product_service;

    public function __construct( SpecialProductService $special_product_service )
    {
        $this->special_product_service = $special_product_service;
    }

    public function store( Request $request )
    {
        $special_product    = $this->special_product_service->storeSpecialProduct( 
                                $request->product_id, 
                                $request->quantity, 
                                $request->selling_price 
                            );

        if ( !$special_product ) {
            return response()->json([
                'message'   => 'Oops!!! Something went wrong.'
            ], 500);
        }

        return response()->json([
            'message'   => 'success'
        ], 200);
    }
}
