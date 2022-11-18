<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/categories',[CategoryController::class,'Store'])->name('api.category.store')->middleware('apikey');
Route::get('/categories/find',[CategoryController::class,'Find'])->name('api.category.find')->middleware('apikey');

//product
Route::post('/product',[ProductController::class,'Store'])->name('api.product.store')->middleware('apikey');


Route::get('/search',[ProductController::class,'Query'])->name('api.product.query')->middleware('apikey');
