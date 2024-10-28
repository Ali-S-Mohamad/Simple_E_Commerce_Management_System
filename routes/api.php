<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('products', [ProductController::class, 'index']);
Route::post('orders/store', [OrderController::class, 'store'])
    ->middleware('auth:sanctum');
Route::get('orders/show/{order}', [OrderController::class, 'show'])
    ->middleware('auth:sanctum');
Route::put('orders/update/{order}', [OrderController::class, 'update'])
    ->middleware('auth:sanctum');
Route::delete('orders/delete/{order}', [OrderController::class, 'destroy'])
    ->middleware('auth:sanctum');