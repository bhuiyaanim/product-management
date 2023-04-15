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
use \App\Http\Controllers\CategoriesController;
use \App\Http\Controllers\BrandsController;
use \App\Http\Controllers\AttributesController;
use \App\Http\Controllers\ProductsController;
use \App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// logout
Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

Route::middleware(['auth:sanctum'])->group(function() {
    // CATEGORY
    Route::resource('categories', CategoriesController::class);
    Route::get('/api/categories', [CategoriesController::class, 'getCategoriesJson']);

    // BRAND
    Route::resource('brands', BrandsController::class);
    
    // ATTRIBUTE
    Route::resource('attributes', AttributesController::class);
    Route::get('/api/attributes', [AttributesController::class, 'getAttributesJson']);

    // Product
    Route::resource('products', ProductsController::class);
});
