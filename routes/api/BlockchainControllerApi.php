<?php

use App\Http\Controllers\BlockchainController;
use Illuminate\Support\Facades\Route;

class BlockchainControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::prefix('blockchain')->group(function () {
                Route::get('/swap', [BlockchainController::class, 'swap']);
                Route::get('/transactions', [BlockchainController::class, 'transactions']);
                Route::get('/purchases', [BlockchainController::class, 'purchases']);
            });
        });
    }
}
