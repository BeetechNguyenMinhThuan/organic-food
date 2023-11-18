<?php

use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\BlogController;
use App\Http\Controllers\User\BrandController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Change Language
Route::get('change-language/{locale}', [HomeController::class, 'changeLanguage'])->name('user.change-language');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('user.login');
Route::get('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/doLogin', [AuthController::class, 'doLogin'])->name('user.doLogin');
Route::post('/doRegister', [AuthController::class, 'doRegister'])->name('user.doRegister');
Route::get('/doLogout', [AuthController::class, 'doLogout'])->name('user.logout');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{name}', [ProductController::class, 'detail'])->name('products.detail');
Route::get('/products-categories/{slug}', [ProductController::class, 'listProduct'])->name('products.listProduct');
Route::get('/products-categories/{categoryId}/filter', [ProductController::class, 'filterProductCategory'])->name('products.filterCategory');
Route::get('/products', [ProductController::class, 'search'])->name('products.search');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/faq', [ProductController::class, 'shop'])->name('faq');
Route::get('/about-us', [ProductController::class, 'shop'])->name('faq');
Route::get('/privacy-policy', [ProductController::class, 'shop'])->name('faq');
Route::get('/term-conditions', [ProductController::class, 'shop'])->name('faq');
Route::get('/purchase-guide', [ProductController::class, 'shop'])->name('faq');
Route::get('/faq', [ProductController::class, 'shop'])->name('faq');
Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');

// Page Contact
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brand/{slug}', [BrandController::class, 'detail'])->name('brands.detail');

// Favorite Product
Route::get("/favorite-product/{productId}", [ProductController::class, 'createFavoriteProduct'])->name('products.create.favorite');
Route::delete("/remove-favorite-product/{productId}", [ProductController::class, 'removeFavoriteProduct'])->name('products.remove.favorite');
Route::get("/check-favorite/{productId}", [ProductController::class, 'checkFavoriteProduct'])->name('products.check.favorite');

// Blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blogs/{slug}', [BlogController::class, 'detail'])->name('blogs.detail');

// Account
Route::middleware('CheckUserLogin')->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post("/add-shipping-address", [AccountController::class, 'addShippingAddress'])->name('account.addShippingAddress');
    Route::delete("/delete-shipping-address/{id}", [AccountController::class, 'deleteShippingAddress'])->name('account.deleteShippingAddress');
    Route::post("/update-account/", [AccountController::class, 'updateAccount'])->name('account.updateAccount');
});


// Cart
Route::get("/add-cart/{productId}", [CartController::class, 'addToCart'])->name('cart.add');
Route::get("/show-cart", [CartController::class, 'showCart'])->name('cart.show');
Route::put("/update-cart", [CartController::class, 'updateCart'])->name('cart.update');
Route::delete("/delete-cart", [CartController::class, 'deleteCart'])->name('cart.delete');
Route::get("/delete-all-cart", [CartController::class, 'deleteAllCart'])->name('cart.allDelete');
Route::middleware('CheckUserLogin')->group(function () {
    Route::post("/checkout-Cart", [CartController::class, 'checkoutCart'])->name('cart.checkout');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
    Lfm::routes();
});


Route::get('logs', [LogViewerController::class, 'index']);
Route::get('/test', function () {
    return Storage::disk(FILESYSTEM)->response('sliders/1/zAR1y0dN145BQrM1KdznIPuXJIDTeH.jpg');
})->name('testimg');
