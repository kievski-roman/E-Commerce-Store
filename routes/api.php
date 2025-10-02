<?php


use App\Http\Controllers\Api\V1\Admin\ProductAdminController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'create'])->name('cart.create');
        Route::get('/', [CartController::class, 'show']);
        Route::post('/', [CartController::class, 'store'])->name('cart.store');
        Route::post('{uuid}/items', [CartItemController::class, 'store']);        // add
        Route::patch('{uuid}/items/{productId}', [CartItemController::class, 'update']); // change qty
        Route::delete('carts/{uuid}/items/{productId}', [CartItemController::class, 'destroy']); // remove

    });
    Route::apiResource('products', ProductController::class);
    Route::get('categories/tree', function () {
        return \App\Http\Resources\CategoryResource::collection(
            \App\Models\Category::with('childrenRecursive')
                ->whereNull('parent_id')
                ->orderBy('position')
                ->get()
        );
    });
});

