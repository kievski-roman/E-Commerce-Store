<?php


use App\Http\Controllers\Api\V1\Admin\ProductAdminController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

// Публічні ендпоінти

Route::apiResource('products', ProductController::class);
// routes/api.php
Route::get('categories/tree', function () {
    return \App\Http\Resources\CategoryResource::collection(
        \App\Models\Category::with('childrenRecursive')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get()
    );
});

// Захищені (авторизовані) ендпоінти
//Route::middleware('auth:sanctum')->group(function () {
//// Кошик
//Route::get('cart', [CartController::class, 'show']);
//Route::post('cart/items', [CartController::class, 'store']);
//Route::put('cart/items/{item}', [CartController::class, 'update']);
//Route::delete('cart/items/{item}', [CartController::class, 'destroy']);
//Route::delete('cart', [CartController::class, 'clear']);
//
//// Замовлення/чекаут
//Route::post('orders', [OrderController::class, 'store']);
//Route::get('orders', [OrderController::class, 'index']);
//Route::get('orders/{order}', [OrderController::class, 'show']);
//Route::post('checkout', [CheckoutController::class, 'store']);
//
//// Адмінка (приклад: політика/гейт чи middleware 'admin')
//Route::middleware('can:manage-products')->group(function () {
//Route::apiResource('admin/products', AdminProductController::class)->except(['show']);
//});
//});
