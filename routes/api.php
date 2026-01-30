<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LoginController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::group(['prefix' => 'v1'], function () {
    Route::post( '/login', [ LoginController::class, 'login' ] );
    Route::post( '/refresh', [ LoginController::class, 'refresh' ] );

    Route::group(['middleware' => 'auth:api'], function () {
        // Product Endpoints
        Route::get( '/product', [ ProductController::class, 'index' ] );
        Route::post( '/product', [ ProductController::class, 'store' ] );

        // Sales Endpoints
        Route::get( '/sales', [ SaleController::class, 'index' ] );
        Route::post( '/sales', [ SaleController::class, 'store' ] );
    });
});
