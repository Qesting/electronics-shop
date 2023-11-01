<?php

use App\Http\Controllers\ProductController;
use App\Models\{Image, Product};
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



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
    '/product/{id}',
    [ProductController::class, 'retrieve']
)->whereNumber('id');

Route::get(
    '/products/{categoryId}',
    [ProductController::class, 'retrieveCategory']
)->whereNumber('categoryId');

Route::get('/', function () {
    return Inertia::render('Test', [
        'args' => [Image::with(['resource'])->get()]
    ]);
});
