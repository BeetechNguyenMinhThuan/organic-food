<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/doLogin', [AuthController::class, 'doLogin'])->name('doLogin');
Route::get('/doLogout', [AuthController::class, 'doLogout'])->name('admin.doLogout');

Route::middleware(['auth:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

    Route::prefix('categories')->middleware(['can:module category'])->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    Route::prefix('menus')->middleware([])->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menus.index');
        Route::post('/store', [MenuController::class, 'store'])->name('admin.menus.store');
        Route::post('/update/{id}', [MenuController::class, 'update'])->name('admin.menus.update');
        Route::delete('/destroy/{id}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');
    });

    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('admin.sliders.index');
        Route::post('/store', [SliderController::class, 'store'])->name('admin.sliders.store');
        Route::post('/update/{id}', [SliderController::class, 'update'])->name('admin.sliders.update');
        Route::delete('/destroy/{id}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        Route::get('{id}/avatar',  [ProductController::class, 'getImage'])->name('admin.product.avatar');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::get('/create', [SettingController::class, 'create'])->name('admin.settings.create');
        Route::post('/store', [SettingController::class, 'store'])->name('admin.settings.store');
        Route::get('/edit/{id}', [SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::put('/update/{id}', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::delete('/destroy/{id}', [SettingController::class, 'destroy'])->name('admin.settings.destroy');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/update/{id}', [RoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    });

    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
        Route::post('/store', [PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::put('/update/{id}', [PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('/destroy/{id}', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('admin.brands.index');
        Route::post('/store', [BrandController::class, 'store'])->name('admin.brands.store');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('admin.brands.update');
        Route::delete('/destroy/{id}', [BrandController::class, 'destroy'])->name('admin.brands.destroy');
    });

    // Blogs
    Route::prefix('blogs')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('admin.blogs.index');
        Route::get('/create', [BlogController::class, 'create'])->name('admin.blogs.create');
        Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('admin.blogs.edit');
        Route::post('/store', [BlogController::class, 'store'])->name('admin.blogs.store');
        Route::put('/update/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
        Route::delete('/destroy/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
    });

    // Orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('admin.orders.detail');
    });
});

