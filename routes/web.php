<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\User\AddressController as UserAddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Payment\MidtransWebhookController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Http\Request;










Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');


Route::get('/product/{slug}', [HomeController::class, 'show'])
    ->name('product.show');

Route::get('/shop', [ShopController::class, 'index'])
    ->name('shop.index');    

Route::get('/search/suggest', [SearchController::class, 'suggest'])
    ->name('search.suggest');

Route::post('/payment/midtrans/notify', [MidtransWebhookController::class, 'notify'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
    ->name('payment.midtrans.notify');

// Cart (session-based; allow guest)
Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CheckoutController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CheckoutController::class, 'updateQty'])->name('cart.update');
Route::delete('/cart/{variantId}', [CheckoutController::class, 'remove'])->name('cart.remove');


Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});


// Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
Route::resource('addresses', AddressController::class);

        Route::get('/search', [AdminSearchController::class, 'index'])->name('search');
        Route::get('/search/suggest', [AdminSearchController::class, 'suggest'])->name('search.suggest');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    });




// User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', fn() => view('user.dashboard'));
Route::resource('addresses', UserAddressController::class);
});




