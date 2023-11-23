<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
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

/* Page routes */
Route::controller(PageController::class)->group(function () {
    Route::get(
        '/product/{productId}',
        'productPage'
    )->whereNumber('productId');

    Route::get(
        '/category/{categoryId}',
        'categoryPage'
    )->whereNumber('categoryId');

    Route::post(
        '/category/{categoryId}',
        'filteredCategoryPage'
    )->whereNumber('categoryId');

    Route::match(
        ['get', 'post'],
        '/cart',
        'cartPage'
    );

    Route::get(
        '/cart/shippingAndPayment',
        'shippingAndPaymentPage'
    );

    Route::get(
        '/cart/checkout',
        'checkoutPage'
    );

    Route::get(
        'cart/order/done',
        'orderedPage'
    );

    Route::get(
        'sale/{saleId}',
        'salePage'
    )->whereNumber('saleId');

    Route::get(
        'user/login',
        'loginPage'
    );

    Route::get(
        'user/register',
        'registerPage'
    );

    Route::get(
        '/',
        'indexPage'
    );
});

/* Cart action routes */
Route::controller(CartController::class)->group(function () {
    Route::put(
        '/cart/add',
        'add'
    );

    Route::put(
        '/cart/update',
        'update'
    );

    Route::post(
        '/cart/checkout',
        'saveShippingData'
    );

    Route::get(
        '/cart/order',
        'order'
    );
});

/* User action routes */
Route::controller(UserController::class)->group(function () {
    Route::post(
        'user/login',
        'login'
    );

    Route::post(
        'user/register',
        'register'
    );
});

/* Logged in routes */
Route::middleware('auth.basic')->group(function () {
    /* Page routes */
    Route::controller(PageController::class)->group(function () {
        Route::get(
            'user/dashboard',
            'dashboardPage'
        );

        Route::get(
            'user/dashboard/shipping',
            'editShippingDataPage'
        );

        Route::get(
            'user/dashboard/passwd',
            'newPasswdPage'
        );
    });

    /* User action routes */
    Route::controller(UserController::class)->group(function () {
        Route::post(
            '/product/{productId}/review',
            'addReview'
        )->whereNumber('productId');

        Route::post(
            'user/dashboard/shipping',
            'saveShippingData'
        );

        Route::post(
            'user/dashboard/passwd',
            'changePasswd'
        );

        Route::get(
            'user/dashboard/logout',
            'logout'
        );
    });
});
