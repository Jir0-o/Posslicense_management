<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Api\SanctumAuthController;
use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/license/{identifier}', [LicenseController::class, 'apiGet']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/license/{identifier}/devices/allowed', [LicenseController::class, 'allowedDevices']);
    Route::post('/license/{identifier}/devices/request', [LicenseController::class, 'requestDevice']);
});

Route::group(['prefix' => 'auth'], function () {
    // Existing users may sign in to obtain a Bearer token. Registration is no
    // longer anonymous; otherwise anyone could create an API user and reach
    // the protected license-device endpoints.
    Route::post('/register', [SanctumAuthController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/login', [SanctumAuthController::class, 'login'])->middleware('throttle:license-login');
    Route::post('/logout', [SanctumAuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::post('/activity', [ActivityController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
