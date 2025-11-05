<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $product_service;

    public function __construct( ProductService $product_service )
    {
        $this->product_service = $product_service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                'message'   => 'product listing'
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param App\Http\Requests\ProductRequest
     * 
     * @bodyParam name string required - name for the product
     * @bodyParam description string optional - description of the product
     * @bodyParam category_id integer required - category id of the product. Example 1=Grocery, 2=Rice
     * @bodyParam price decimal(0, 2) required - price of the product
     * @bodyParam mark_up numeric required - percentage mark up of the product
     * @bodyParam selling_price required - selling price of the product (price + mark up)
     */
    public function store(ProductRequest $request)
    {
        $name           = $request->name;
        $description    = $request->description;
        $category_id    = $request->category_id;
        $price          = $request->price;
        $mark_up        = $request->mark_up;
        $selling_price  = $request->selling_price;

        $product = $this->product_service->storeProduct(
            $name,
            $description,
            $category_id,
            $price,
            $mark_up,
            $selling_price
        );

        return response()->json([
            'message' => 'Product succesfully saved.'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
