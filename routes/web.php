<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the 'web' middleware group. Make something great!
|
*/

Route::get(
    '/product/{productId}',
    [PageController::class, 'productPage']
)->whereNumber('productId');

Route::get(
    '/category/{categoryId}',
    [PageController::class, 'categoryPage']
)->whereNumber('categoryId');

Route::post(
    '/category/{categoryId}',
    [PageController::class, 'filteredCategoryPage']
)->whereNumber('categoryId');

Route::match(
    ['get', 'post'],
    '/cart',
    [PageController::class, 'cartPage']
);

Route::put(
    '/cart/add',
    [CartController::class, 'add']
);

Route::put(
    '/cart/update',
    [CartController::class, 'update']
);

Route::get(
    '/cart/checkout',
    [PageController::class, 'checkoutPage']
);

Route::post(
    '/cart/checkout',
    [PageController::class, 'endCheckoutPage']
);

Route::get('/', [PageController::class, 'indexPage']);
