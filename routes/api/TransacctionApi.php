<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

class TransactionApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte|usuario']], function () {
            Route::get('transactions/my-transactions', [TransactionController::class, 'index']);
            Route::post('transactions/swap', [TransactionController::class, 'swap']);
        });
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::get('transactions', [TransactionController::class, 'indexAll']);
        });
    }
}
