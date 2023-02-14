<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products',[\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}',[\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/variant/{variant_code}', [\App\Http\Controllers\ProductController::class, 'getConfigurations'])->name('variants.configurations');
Route::get('/product/{product_code}', [\App\Http\Controllers\ProductController::class, 'getProductConfigurations'])->name('product.configurations');
