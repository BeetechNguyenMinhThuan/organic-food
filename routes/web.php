<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/products/{name}', [ProductController::class,'detail'])->name('products.detail');
Route::get('/products-categories/{slug}', [ProductController::class,'listProduct'])->name('products.listProduct');
Route::get('/products', [ProductController::class,'search'])->name('products.search');


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']], function () {
    Lfm::routes();
});



Route::get('logs', [LogViewerController::class, 'index']);
Route::get('/test',function () {
    return Storage::disk(FILESYSTEM)->response('sliders/1/zAR1y0dN145BQrM1KdznIPuXJIDTeH.jpg');
})->name('testimg');
