<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductQuestionController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Route custom kamu
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::get('/produk', [ProductController::class, 'index'])->name('product');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('product.category');

// Route Breeze (auth, dashboard, profile)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Wishlist routes
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

// Order and Payment Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store'); // Manual payment store
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('payments/{payment}/receipt-pdf', [PaymentController::class, 'generateReceiptPdf'])->name('payments.receipt.pdf');

    // Review Routes
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Product Question Routes
    Route::post('/products/{product}/questions', [ProductQuestionController::class, 'store'])->name('product.questions.store');
    Route::post('/product-questions/{question}/answer', [ProductQuestionController::class, 'answer'])->name('product.questions.answer')->middleware('admin');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout route
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/payment/{order}', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
});

// Google Login Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

// Order Tracking Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// Route auth dari Breeze
require __DIR__.'/auth.php'; 