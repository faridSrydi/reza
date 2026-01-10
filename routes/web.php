<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\User\AddressController as UserAddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CheckoutController;










Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/product/{slug}', [HomeController::class, 'show'])
    ->name('product.show');


Route::middleware('auth')->group(function () {
    // Tambahkan route ini untuk menangani tombol "Tambah ke Keranjang"
    Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');


    Route::get('/cart', [CheckoutController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CheckoutController::class, 'updateQty'])->name('cart.update');
    Route::delete('/cart/{variantId}', [CheckoutController::class, 'remove'])->name('cart.remove');


    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});


// Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        Route::get('/dashboard', fn() => view('admin.dashboard'))
            ->name('dashboard');


        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
Route::resource('addresses', AddressController::class);
    });




// User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', fn() => view('user.dashboard'));
Route::resource('addresses', UserAddressController::class);
});




