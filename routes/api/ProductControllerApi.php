<?php

use App\Http\Controllers\{ProductController};
use Illuminate\Support\Facades\Route;

class ProductControllerApi
{
    public static function set()
    {
        $route = 'products/{product}';

        Route::group(['middleware' => ['role:administracion|soporte']], function () use ($route) {
            Route::post('products/save', [ProductController::class, 'store']);
            Route::put($route, [ProductController::class, 'update']);
            Route::delete($route, [ProductController::class, 'destroy']);

            Route::get('products/next-contract-id/{variant}', [ProductController::class, 'nextContractId']);
            Route::post('products/set-contract-id', [ProductController::class, 'setContractId']);
        });

        Route::group(['middleware' => ['role:administracion|soporte|usuario']], function () use ($route) {
            Route::get('products', [ProductController::class, 'index']);
            Route::get($route, [ProductController::class, 'show']);
            Route::get($route.'/show-more', [ProductController::class, 'showMore']);
            Route::get('/products/{product}/variants', [ProductController::class, 'variants']);
        });
    }
}
