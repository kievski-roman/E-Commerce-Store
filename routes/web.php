<?php

use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.product.index');
        Route::post('/', [AdminProductController::class, 'store'])->name('admin.product.store');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.product.create');
        // maybe delete this route bcs i can use it in index modal window
        Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.product.edit');
        Route::patch('/{product}', [AdminProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('admin.product.destroy');
    });
    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('admin.order.index');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('admin.order.destroy');
    });
    Route::get('/payment/{order}', [AdminOrderController::class, 'index'])->name('admin.order.index');
});


Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/', [CartController::class, 'clear'])->name('cart.clear');
});

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::post('/', [OrderController::class, 'store'])->name('order.store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('order.show');
});
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::post('/', [OrderController::class, 'store'])->name('order.store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('order.show');
});



require __DIR__.'/auth.php';
