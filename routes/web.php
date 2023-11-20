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
    '/cart/shippingAndPayment',
    [PageController::class, 'shippingAndPaymentPage']
);

Route::post(
    '/cart/checkout',
    [CartController::class, 'saveShippingData']
);

Route::get(
    '/cart/checkout',
    [PageController::class, 'checkoutPage']
);

Route::get(
    '/cart/order',
    [CartController::class, 'order']
);

Route::get(
    'cart/order/done',
    [PageController::class, 'orderedPage']
);

Route::get(
    'sale/{saleId}',
    [PageController::class, 'salePage']
)->whereNumber('saleId');

Route::get('/', [PageController::class, 'indexPage']);
