<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\OurServicesController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::prefix('admin')->group(function () {

    // Admin Login
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);

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
            Route::get('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product'); // GET for rendering the form
            Route::post('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product.post');
            Route::post('delete-product/{id}', [ProductsController::class, 'delete_product'])->name('admin.delete_product');
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

        // Our Services
        Route::prefix('ourservices')->group(function () {
            Route::get('/', [OurServicesController::class, 'index'])->name('admin.ourservices.index');
            Route::get('/create', [OurServicesController::class, 'create'])->name('admin.ourservices.create');
            Route::post('/', [OurServicesController::class, 'store'])->name('admin.ourservices.store');
            Route::get('{id}/edit', [OurServicesController::class, 'edit'])->name('admin.ourservices.edit');
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
    });
});
