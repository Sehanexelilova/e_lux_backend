<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\PaymentMethodsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Routes
Route::middleware('api')->group(function () {
    Route::get('/partners', [PartnerController::class, 'getPartners']);
    Route::get('/home-banners', [HomeBannerController::class, 'getBanners']);
    Route::get('/payment-methods', [PaymentMethodsController::class, 'getPaymentMethods']);
});
