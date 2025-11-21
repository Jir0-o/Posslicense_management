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

Route::group(['prefix'=>'auth'], function(){
    Route::post('/register', [SanctumAuthController::class, 'store']);
    Route::post('/login', [SanctumAuthController::class, 'login']);
    Route::post('/logout', [SanctumAuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::post('/activity', [ActivityController::class, 'store']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
