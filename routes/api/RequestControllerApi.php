<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

class RequestControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::prefix('requests')->group(function () {
                Route::post('/', [RequestController::class, 'store']);
            });
        });
    }
}
