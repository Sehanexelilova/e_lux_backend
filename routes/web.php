<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\OurServicesController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\BasketController;

use App\Http\Controllers\Admin\ProductsDescriptionController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductReviewController;


// Public Routes
Route::get('/', function () {
    return view('welcome');
});


// Admin Routes .. bu hissədə zatən prefix "admin" olaraq vermisiz aşağı hissələrdə yenidən admin yazmağınıza ehtiyyac yoxdur 
Route::prefix('admin')->group(function () {

    // Admin Login
    // bunlara middleware əlavə etməlisiz əgər admin giriş edibsə çıxış etmədiyi müddətcə bu routlara giriş edə bilməsin əgər girmək istəsə /dasboard səhifəsinə göndərsin. Belə bir middleware əlavə edərsiz
    Route::get('/login', [AdminController::class, 'index'])->name('login');//????????????????????????????????????

    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');

    Route::middleware([Admin::class])->group(function () {

        // Dashboard
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Admin Profile Management
        Route::get('/update-password-page', [AdminController::class, 'update_password_page'])->name('admin.update_password');
        Route::post('/update-password', [AdminController::class, 'update_password'])->name('admin.update_password.post');
        Route::get('/details', [AdminController::class, 'adminDetails'])->name('admin.details');
        Route::get('/admin/edit-profile', [AdminController::class, 'editProfile'])->name('admin.edit_profile');
        Route::post('/admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update_profile');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Categories
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
            Route::post('/', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::put('{id}', [CategoryController::class, 'update'])->name('admin.category.update');
            Route::delete('{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        });

        // Products
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductsController::class, 'products'])->name('admin.products');
            Route::get('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product');
            Route::post('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product.post');
            Route::delete('delete-product/{id}', [ProductsController::class, 'delete_product'])->name('admin.delete_product');

        });

        // Posts
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.posts.index');
            Route::get('/create', [PostController::class, 'create'])->name('admin.posts.create');
            Route::post('/', [PostController::class, 'store'])->name('admin.posts.store');
            Route::get('{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
            Route::put('{post}', [PostController::class, 'update'])->name('admin.posts.update');
            Route::delete('{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
        });

        // Shipping Methods
        Route::prefix('shipping-methods')->group(function () {
            Route::get('/', [ShippingMethodController::class, 'index'])->name('admin.shipping.index');
            Route::get('/create', [ShippingMethodController::class, 'create'])->name('admin.shipping.create');
            Route::post('/', [ShippingMethodController::class, 'store'])->name('admin.shipping.store');
            Route::get('{id}/edit', [ShippingMethodController::class, 'edit'])->name('admin.shipping.edit');
            Route::put('{id}', [ShippingMethodController::class, 'update'])->name('admin.shipping.update');
            Route::delete('{id}', [ShippingMethodController::class, 'destroy'])->name('admin.shipping.destroy');
        });

        // Partners
        Route::prefix('partners')->group(function () {
            Route::get('/', [PartnerController::class, 'index'])->name('admin.partners.index');
            Route::get('/create', [PartnerController::class, 'create'])->name('admin.partners.create');
            Route::post('/', [PartnerController::class, 'store'])->name('admin.partners.store');
            Route::get('/edit/{partner}', [PartnerController::class, 'edit'])->name('admin.partners.edit');
            Route::put('{partner}', [PartnerController::class, 'update'])->name('admin.partners.update');
            Route::delete('{partner}', [PartnerController::class, 'destroy'])->name('admin.partners.destroy');
        });

        //Home Banners
        Route::prefix('home_banners')->group(function () {
            Route::get('/', [HomeBannerController::class, 'index'])->name('admin.home_banners.index');
            Route::get('/create', [HomeBannerController::class, 'create'])->name('admin.home_banners.create');
            Route::post('/', [HomeBannerController::class, 'store'])->name('admin.home_banners.store');
            Route::get('edit/{id}', [HomeBannerController::class, 'edit'])->name('admin.home_banners.edit');
            Route::put('{id}', [HomeBannerController::class, 'update'])->name('admin.home_banners.update');
            Route::delete('{id}', [HomeBannerController::class, 'destroy'])->name('admin.home_banners.destroy');
        });

        //Payment Methods
        Route::prefix('payment_methods')->group(function () {
            Route::get('/', [PaymentMethodsController::class, 'index'])->name('admin.payment_methods.index');
            Route::get('/create', [PaymentMethodsController::class, 'create'])->name('admin.payment_methods.create');
            Route::post('/', [PaymentMethodsController::class, 'store'])->name('admin.payment_methods.store');
            Route::get('edit/{id}', [PaymentMethodsController::class, 'edit'])->name('admin.payment_methods.edit');
            Route::put('{id}', [PaymentMethodsController::class, 'update'])->name('admin.payment_methods.update');
            Route::delete('{id}', [PaymentMethodsController::class, 'destroy'])->name('admin.payment_methods.destroy');
        });

        // Our Services
        Route::prefix('ourservices')->group(function () {
            Route::get('/', [OurServicesController::class, 'index'])->name('admin.ourservices.index');
            Route::get('/create', [OurServicesController::class, 'create'])->name('admin.ourservices.create');
            Route::post('/', [OurServicesController::class, 'store'])->name('admin.ourservices.store');
            Route::get('/edit/{id}', [OurServicesController::class, 'edit'])->name('admin.ourservices.edit');
            Route::put('{id}', [OurServicesController::class, 'update'])->name('admin.ourservices.update');
            Route::delete('{id}', [OurServicesController::class, 'destroy'])->name('admin.ourservices.destroy');

            // Our Service Items
            Route::prefix('items')->group(function () {
                Route::get('/create', [OurServicesController::class, 'createItem'])->name('admin.ourservices.items.create');
                Route::post('/', [OurServicesController::class, 'storeItem'])->name('admin.ourservices.items.store');
                Route::get('/edit/{id}', [OurServicesController::class, 'editItem'])->name('admin.ourservices.items.edit');
                Route::put('/{id}', [OurServicesController::class, 'updateItem'])->name('admin.ourservices.items.update');
                Route::delete('{id}', [OurServicesController::class, 'destroyItem'])->name('admin.ourservices.items.destroy');
            });
        });
        // Product Descriptions
        Route::prefix('products_description')->group(function () {
            Route::get('/', [ProductsDescriptionController::class, 'index'])->name('admin.products_description.index');
            Route::get('/create', [ProductsDescriptionController::class, 'create'])->name('admin.products_description.create');
            Route::post('/', [ProductsDescriptionController::class, 'store'])->name('admin.products_description.store');
            Route::get('/edit/{id}', [ProductsDescriptionController::class, 'edit'])->name('admin.products_description.edit');
            Route::put('/{id}', [ProductsDescriptionController::class, 'update'])->name('admin.products_description.update');
            Route::delete('/{id}', [ProductsDescriptionController::class, 'destroy'])->name('admin.products_description.destroy');
        });

        // Product Reviews
        Route::prefix('product_reviews')->group(function () {
            Route::get('/', [ProductReviewController::class, 'index'])->name('admin.product_reviews.index');
            Route::get('/create', [ProductReviewController::class, 'create'])->name('admin.product_reviews.create');
            Route::post('/', [ProductReviewController::class, 'store'])->name('admin.product_reviews.store');
            Route::get('/edit/{id}', [ProductReviewController::class, 'edit'])->name('admin.product_reviews.edit');
            Route::put('/{id}', [ProductReviewController::class, 'update'])->name('admin.product_reviews.update');
            Route::delete('/{id}', [ProductReviewController::class, 'destroy'])->name('admin.product_reviews.destroy');
        });
        //Cart
        Route::group(['prefix' => 'cart', 'as' => 'admin.cart.'], function () {
            Route::get('/cart', [BasketController::class, 'index'])->name('index');
            Route::post('/store', [BasketController::class, 'store'])->name('store');
            Route::post('/remove', [BasketController::class, 'remove'])->name('remove');
        });
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');



        //adminin login ui hissəsi var?ui nedi Login səhifəsi var admin üçün?))var oranı göstərin
        Route::get('/orders', [OrderController::class, 'adminOrdersIndex'])->name('admin.orders.index');
        Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        // Route::middleware(["auth", 'admin'])->group(function () {

        // });

    });
});
