<?php

use App\Http\Controllers\{ModuleController};
use Illuminate\Support\Facades\Route;

class ModuleControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|usuario|soporte']], function () {
            Route::get('/modules', [ModuleController::class, 'index']);
            Route::get('/modules/user', [ModuleController::class, 'user']);
            Route::post('/modules/rangue', [ModuleController::class, 'rangue']);
        });
    }
}
