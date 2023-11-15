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
    [PageController::class, 'productPage']
)->whereNumber('productId');

// those entities are for {}, used not to confuse the engine
Route::permanentRedirect(
    '/category/{categoryId}', '/category/{categoryId}/%7B%7D'
)->whereNumber('categoryId');

Route::get(
    '/category/{categoryId}/{filters?}',
    [PageController::class, 'categoryPage']
)->whereNumber('categoryId');

Route::get('/', [PageController::class, 'indexPage']);
