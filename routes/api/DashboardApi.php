<?php

use App\Http\Controllers\{DashboardController};
use Illuminate\Support\Facades\Route;

class DashboardApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|usuario']], function () {
            Route::prefix('dashboard')->group(function () {
                Route::get('/my-network', [DashboardController::class, 'myNetWork']);
                Route::get('/network/{user?}', [DashboardController::class, 'netWork']);
                Route::post('/network/download', [DashboardController::class, 'netWorkDownload']);
                Route::get('/direct-referreds-counter', [DashboardController::class, 'directReferredsCounter']);
                Route::get('/volumen', [DashboardController::class, 'volumen']);
            });
        });
    }
}
