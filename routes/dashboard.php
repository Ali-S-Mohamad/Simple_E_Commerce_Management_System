<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;

Route::group([
    'middleware' => ['auth', 'user-role'],
    'as' => 'dashboard.',
    'prefix' => 'dashboard'
], function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Routes For Categories Soft Deletes
    Route::get('/categories/trash', [CategoryController::class, 'trash'])
        ->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
        ->name('categories.force-delete');


    // Routes For Products Soft Deletes
    Route::get('/products/trash', [ProductController::class, 'trash'])
        ->name('products.trash');
    Route::put('products/{product}/restore', [ProductController::class, 'restore'])
        ->name('products.restore');
    Route::delete('products/{product}/force-delete', [ProductController::class, 'forceDelete'])
        ->name('products.force-delete');


    // Routes For Orders Soft Deletes
    Route::get('/orders/trash', [OrderController::class, 'trash'])
        ->name('orders.trash');
    Route::put('orders/{order}/restore', [OrderController::class, 'restore'])
        ->name('orders.restore');
    Route::delete('orders/{order}/force-delete', [OrderController::class, 'forceDelete'])
        ->name('orders.force-delete');

    // Resources routes
    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/orders', OrderController::class);
});


