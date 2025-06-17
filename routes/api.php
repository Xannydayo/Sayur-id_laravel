<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CouponController;

Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
});

// Coupon routes
Route::post('/coupons/apply', [CouponController::class, 'apply']);
Route::post('/coupons', [CouponController::class, 'store']);