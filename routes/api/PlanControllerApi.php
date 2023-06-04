<?php

use App\Http\Controllers\{PlanController};
use Illuminate\Support\Facades\Route;

class PlanControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte|usuario']], function () {
            Route::get('/plans', [PlanController::class, 'index']);
        });

        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            $plansRoute = '/plans/{plan}';
            Route::post('/plans/save', [PlanController::class, 'store']);
            Route::get($plansRoute, [PlanController::class, 'show']);
            Route::put($plansRoute, [PlanController::class, 'update']);
            Route::post('/plans/{plan}/image', [PlanController::class, 'updateImage']);
            Route::delete($plansRoute, [PlanController::class, 'destroy']);
        });
    }
}
