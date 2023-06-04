<?php

use App\Http\Controllers\{ReportController};
use Illuminate\Support\Facades\Route;

class ReportControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::prefix('reports')->group(function () {
                Route::post('/invite', [ReportController::class, 'invite']);
                Route::post('/register', [ReportController::class, 'register']);
                Route::post('/rangues', [ReportController::class, 'rangues']);
            });

            Route::prefix('reports/user')->group(function () {
                Route::post('/invite', [ReportController::class, 'inviteUser']);
                Route::post('/wallet', [ReportController::class, 'userWallets']);
                Route::post('/register', [ReportController::class, 'registerUser']);
            });
        });
    }
}
