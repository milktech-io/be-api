<?php

use App\Http\Controllers\MultilanguageController;
use Illuminate\Support\Facades\Route;

class MultilangaugeControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            $route = 'multilanguage/{multilanguage}';
            Route::get('multilanguage', [MultilanguageController::class, 'index']);
            Route::get($route, [MultilanguageController::class, 'show']);
            Route::post('multilanguage', [MultilanguageController::class, 'store']);
            Route::put($route, [MultilanguageController::class, 'update']);
            Route::delete($route, [MultilanguageController::class, 'destroy']);
        });
    }
}
