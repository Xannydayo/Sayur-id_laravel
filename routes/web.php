<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kontak', [HomeController::class, 'contact']);
Route::get('/produk', [ProductController::class, 'index'])->name('product');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/kategori/{slug}', [ProductController::class, 'category'])->name('product.category');