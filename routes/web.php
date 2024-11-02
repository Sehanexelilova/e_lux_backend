<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\PostController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::middleware([Admin::class])->group(function () {
    
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/update-password-page', [AdminController::class, 'update_password_page'])->name('admin.update_password');
        Route::post('/update-password', [AdminController::class, 'update_password'])->name('admin.update_password.post');
        Route::get('/details', [AdminController::class, 'adminDetails'])->name('admin.details');
        Route::get('/admin/edit-profile', [AdminController::class, 'editProfile'])->name('admin.edit_profile');
        Route::post('/admin/update-profile', [AdminController::class, 'updateProfile'])->name('admin.update_profile');
        
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        //categories

        Route::get('categories', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        //products
        Route::get('products', [ProductsController::class, 'products'])->name('admin.products');
        Route::get('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product'); // GET for rendering the form
        Route::post('add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('admin.products.add_edit_product.post');

        Route::post('delete-product/{id}', [ProductsController::class, 'delete_product'])->name('admin.delete_product');
    //post
    Route::get('posts', [PostController::class, 'index'])->name('admin.posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('posts', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');

    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    
   //shipping
   Route::get('shipping-methods', [ShippingMethodController::class, 'index'])->name('admin.shipping.index');
   Route::get('shipping-methods/create', [ShippingMethodController::class, 'create'])->name('admin.shipping.create');
   Route::post('shipping-methods', [ShippingMethodController::class, 'store'])->name('admin.shipping.store');
   Route::get('shipping-methods/{id}/edit', [ShippingMethodController::class, 'edit'])->name('admin.shipping.edit');
   Route::put('shipping-methods/{id}', [ShippingMethodController::class, 'update'])->name('admin.shipping.update');
   Route::delete('shipping-methods/{id}', [ShippingMethodController::class, 'destroy'])->name('admin.shipping.destroy');
});

});
