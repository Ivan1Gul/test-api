<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationMapController;
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
Route::prefix('location-maps')->group(function () {
    Route::get('/', [LocationMapController::class, 'get']);
});

Route::middleware('api')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'get']);
    });
});

Route::prefix('businesses')->group(function () {
    Route::get('/', [BusinessController::class, 'get']);
    Route::get('/{id}', [BusinessController::class, 'getById']);
});

Route::prefix('advertisement')->group(function () {
    Route::post('/', [AdvertisementController::class, 'create']);
});


