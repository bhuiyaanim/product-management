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
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\UsersController;
use \App\Http\Controllers\CategoriesController;
use \App\Http\Controllers\BrandsController;
use \App\Http\Controllers\SizesController;
use \App\Http\Controllers\ProductsController;
use \App\Http\Controllers\StocksController;
use \App\Http\Controllers\ReturnProductsController;
use \App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return redirect('/login');
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
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // USERS
    Route::resource('users', UsersController::class);

    // CATEGORY
    Route::resource('categories', CategoriesController::class);
    Route::get('/api/categories', [CategoriesController::class, 'getCategoriesJson']);

    // BRAND
    Route::resource('brands', BrandsController::class);
    Route::get('/api/brands', [BrandsController::class, 'getBrandsJson']);

    // SIZE
    Route::resource('sizes', SizesController::class);
    Route::get('/api/sizes', [SizesController::class, 'getSizesJson']);

    // Product
    Route::resource('products', ProductsController::class);
    Route::get('/api/products', [ProductsController::class, 'getProductsJson']);

    // Stock
    Route::get('/stocks', [StocksController::class, 'stock'])->name('stock');
    Route::post('/stocks', [StocksController::class, 'stockSubmit'])->name('stockSubmit');
    Route::get('/stocks/history', [StocksController::class, 'history'])->name('stockHistory');
    
    // Return Product
    Route::get('/return-products', [ReturnProductsController::class, 'returnProducts'])->name('returnProducts');
    Route::post('/return-products', [ReturnProductsController::class, 'returnProductSubmit'])->name('returnProductSubmit');
    Route::get('/return-products/history', [ReturnProductsController::class, 'history'])->name('returnProductsHistory');
});
