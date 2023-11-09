<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
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
    [ProductController::class, 'retrieve']
)->whereNumber('productId');

Route::get(
    '/category/{categoryId}',
    [PageController::class, 'categoryPage']
)->whereNumber('categoryId');

Route::get('/', [PageController::class, 'indexPage']);
