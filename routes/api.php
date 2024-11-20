<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;

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

Route::prefix('/orders')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::post('/{id}/update', 'update');
    Route::post('/{id}/complete', 'complete');
    Route::post('/{id}/cancel', 'cancel');
    Route::post('/{id}/resume', 'resume');
});

Route::prefix('/products')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/movements', 'getMovements');
});

Route::get('/warehouses', [WarehouseController::class, 'index']);