<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Products Management
        Route::get('products', [ProductController::class, 'index'])->name('products.index');
        Route::get('products/data', [ProductController::class, 'getData'])->name('products.data');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Categories Management
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/data', [CategoryController::class, 'getData'])->name('categories.data');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Orders Management
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/data', [OrderController::class, 'getData'])->name('orders.data');
        Route::get('orders/users', [OrderController::class, 'getUsers'])->name('orders.users');
        Route::get('orders/statuses', [OrderController::class, 'getStatuses'])->name('orders.statuses');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

require __DIR__.'/auth.php';
