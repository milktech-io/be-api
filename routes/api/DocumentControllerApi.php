<?php

use App\Http\Controllers\{DocumentController};
use Illuminate\Support\Facades\Route;

class DocumentControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|usuario']], function () {
            Route::prefix('documents')->group(function () {
                Route::get('/', [DocumentController::class, 'index']);
            });
        });

        Route::group(['middleware' => ['role:administracion']], function () {
            Route::prefix('documents')->group(function () {
                Route::post('/save', [DocumentController::class, 'store']);
                Route::delete('/{document}', [DocumentController::class, 'destroy']);
                Route::post('/{document}/update', [DocumentController::class, 'update']);
                Route::post('download', [DocumentController::class, 'download']);
            });
        });
    }

    public static function public()
    {
        Route::post('documents/public/{name}', [DocumentController::class, 'publicName']);
    }
}
