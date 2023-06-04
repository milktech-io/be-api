<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

class PurchasedControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion']], function () {
            Route::post('purchase/admin', [PurchaseController::class, 'purchaseAdmin']);

            Route::get('purchase/{purchase}/comissions', [PurchaseController::class, 'comissions']);
            Route::post('purchase/{purchase}/comissions', [PurchaseController::class, 'setComissions']);
        });

        $route = 'purchase/{purchase}';
        Route::group(['middleware' => ['role:administracion|soporte|usuario']], function () use ($route) {
            Route::get('my-purchases', [PurchaseController::class, 'index']);
            Route::get($route, [PurchaseController::class, 'show']);
            Route::post('purchase/save', [PurchaseController::class, 'store']);
        });
        Route::group(['middleware' => ['role:administracion|soporte']], function () use ($route) {
            Route::get('purchases', [PurchaseController::class, 'indexAll']);
            Route::post('purchase/free', [PurchaseController::class, 'storeFree']);
            Route::put($route, [PurchaseController::class, 'update']);
            Route::delete($route, [PurchaseController::class, 'destroy']);
        });
    }
}
