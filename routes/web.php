<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerProductsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Customer Products
|--------------------------------------------------------------------------
*/

Route::get(
    '/customer/products',
    [CustomerProductsController::class, 'index']
)->name('customer.products');


/*
|--------------------------------------------------------------------------
| Authenticated Admin / Product Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Product Trash
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/products/trash',
        [ProductController::class, 'trash']
    )->name('products.trash');


    /*
    |--------------------------------------------------------------------------
    | Product Analytics
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/products/analytics',
        [ProductController::class, 'analytics']
    )->name('products.analytics');


    /*
    |--------------------------------------------------------------------------
    | Product CSV Export
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/products/export',
        [ProductController::class, 'export']
    )->name('products.export');


    /*
    |--------------------------------------------------------------------------
    | Restore Product
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/products/{id}/restore',
        [ProductController::class, 'restore']
    )->name('products.restore');


    /*
    |--------------------------------------------------------------------------
    | Permanent Delete
    |--------------------------------------------------------------------------
    */

    Route::delete(
        '/products/{id}/force-delete',
        [ProductController::class, 'forceDelete']
    )->name('products.force-delete');


    /*
    |--------------------------------------------------------------------------
    | Product CRUD
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'products',
        ProductController::class
    );
});


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [
            ProfileController::class,
            'destroy'
        ]
    )->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
