<?php

use App\Http\Controllers\{SkillController};
use Illuminate\Support\Facades\Route;

class SkillControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion']], function () {
            Route::post('/skills', [SkillController::class, 'index']);
        });
    }
}
