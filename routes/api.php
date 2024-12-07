<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\OurServicesController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\Api\ProductsDescriptionController;
use App\Http\Controllers\Admin\Api\ProductReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\PaymentController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API Routes
Route::middleware('api')->group(function () {
    Route::get('/partners', [PartnerController::class, 'getPartners']);
    Route::get('/home-banners', [HomeBannerController::class, 'getBanners']);
    Route::get('/payment-methods', [PaymentMethodsController::class, 'getPaymentMethods']);
    Route::get('/our-services', [OurServicesController::class, 'getOurServices']);
    Route::get('/products', [ProductsController::class, 'getProducts']);
    Route::get('/product-details/{id}', [ProductsDescriptionController::class, 'show']);
    Route::get('/posts', [PostController::class, 'getPosts']);
    Route::get('/posts/{id}', [PostController::class, 'show']);

    Route::get('product/category/{categoryId}', [ProductsController::class, 'getProductsByCategory'])->name('admin.products.by_category');
    Route::post('/filter-products', [ProductsController::class, 'filterProducts']);
    Route::get('product/search', [ProductsController::class, 'searchProducts'])->name('admin.products.search');
    Route::post('/product-reviews', [ProductReviewController::class, 'store']);
    Route::put('/product-reviews/{id}', [ProductReviewController::class, 'update']);
    Route::delete('/product-reviews/{id}', [ProductReviewController::class, 'destroy']);
    Route::get('/product-reviews', [ProductReviewController::class, 'index']);
    Route::get('/product-reviews/{productId}', [ProductReviewController::class, 'getReviewsByProduct']);

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    //cart

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/cart', [BasketController::class, 'index']);
        Route::post('/cart/store', [BasketController::class, 'store']);
        Route::post('/cart/remove', [BasketController::class, 'remove']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
    });
    Route::post('/shipping-address', [ShippingAddressController::class, 'store']);
    Route::post('/process-payment', [PaymentController::class, 'processPayment'])->middleware('auth:sanctum');

});
