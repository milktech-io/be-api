<?php

use App\Http\Controllers\UserDeleteController;
use Illuminate\Support\Facades\Route;

class UserDeleteApi
{
    public static function set()
    {
        Route::prefix('users-delete')->group(function () {
            Route::post('/request', [UserDeleteController::class, 'request']);
            Route::post('/delete', [UserDeleteController::class, 'delete'])
                ->middleware('requestAction');
        });

        Route::group(['middleware' => ['role:administracion|soporte']], function () {
            Route::post('users-delete/delete/{user}', [UserDeleteController::class, 'deleteUser']);
        });
    }
}
