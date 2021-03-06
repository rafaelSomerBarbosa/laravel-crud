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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\CategoryController::class, 'index']);
Route::resource('categorias', App\Http\Controllers\CategoryController::class);
Route::resource('produtos', App\Http\Controllers\ProductController::class);
Route::resource('image', App\Http\Controllers\ImageController::class);
