<?php

use App\Http\Controllers\Api\LicenseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| License Verification & Activation API for Desktop (C# WPF)
|--------------------------------------------------------------------------
|
| Endpoints:
| - POST /api/license/activate
| - POST /api/license/verify
|
*/
Route::prefix('license')->middleware('throttle:30,1')->group(function () {
    Route::post('/activate', [LicenseController::class, 'activate'])->name('api.license.activate');
    Route::post('/verify', [LicenseController::class, 'verify'])->name('api.license.verify');
});
