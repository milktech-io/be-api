<?php

use App\Http\Controllers\{SupportController};
use Illuminate\Support\Facades\Route;

class SupportControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|usuario']], function () {
            Route::prefix('support')->group(function () {
                Route::post('/create-ticket', [SupportController::class, 'createTicket']);
                Route::post('/view-ticket', [SupportController::class, 'viewTicket']);
                Route::post('/reply-ticket', [SupportController::class, 'replyTicket']);
                Route::get('/list-ticket', [SupportController::class, 'listTicket']);
            });
        });
    }

    public static function client()
    {
        Route::prefix('support')->group(function () {
            Route::post('/create-ticket/client', [SupportController::class, 'createTicketClient']);
        });
    }
}
