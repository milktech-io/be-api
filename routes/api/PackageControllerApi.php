<?php

use App\Http\Controllers\{PackageController};
use Illuminate\Support\Facades\Route;

class PackageControllerApi
{
    public static function set()
    {
        Route::group(['middleware' => ['role:administracion|soporte|usuario']], function () {
            Route::get('packages/my-packages', [PackageController::class, 'myPackages']);
            Route::post('purchased-package', [PackageController::class, 'purchasedPackage']);
            Route::get('packages', [PackageController::class, 'index']);
            Route::get('packages/{package}', [PackageController::class, 'show']);
            Route::get('packages/last-month', [PackageController::class, 'lastMonth']);
            Route::post('loop', [PackageController::class, 'loop']);
            Route::post('loop-user', [PackageController::class, 'loopUser']);
            Route::post('package-special', [PackageController::class, 'packageSpecial']);
        });
    }
}
