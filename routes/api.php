<?php

use Illuminate\Support\Facades\Route;

include_once __DIR__.'/api/index.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['jwt'])->group(function () {
    ProfileControllerApi::set();
    AuthControllerApi::set();
    AuthControllerApi::forWeb();
    SupportControllerApi::client();
    DocumentControllerApi::public();

    Route::middleware(['user'])->group(function () {
        AuthControllerApi::check();
        ReportControllerApi::set();
        ModuleControllerApi::set();
        UserApi::set();
        UserDeleteApi::set();
        RolesApi::set();
        EventControllerApi::set();
        DashboardApi::set();
        SupportControllerApi::set();
        DocumentControllerApi::set();
        RequestControllerApi::set();
        BlockchainControllerApi::set();
        PurchasedControllerApi::set();
        TransactionApi::set();
        ProductControllerApi::set();
        PlanControllerApi::set();
        PackageControllerApi::set();
        MultilangaugeControllerApi::set();
    });
});
