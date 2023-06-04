<?php

use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class RolesApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::put('/users/{user}/profile', [UserController::class, 'updateProfile']);
            Route::post('/users/{user}/unlock', [UserController::class, 'unlock']);

            Route::resource('/roles', RoleController::class);
            Route::get('/permissions', [PermissionsController::class, 'index']);
            Route::resource('/tokens', TokenController::class);
        });
    }
}
