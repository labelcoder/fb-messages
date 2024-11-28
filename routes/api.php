<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\Facebook\FacebookLiveController;
use App\Http\Controllers\Api\v1\OrderController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'],function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

Route::prefix('categories')->group(function () {
    Route::post('store', [CategoryController::class, 'store'])->name('api.v1.categories.store');
    Route::post('update', [CategoryController::class, 'update'])->name('api.v1.categories.update');
    Route::post('destroy', [CategoryController::class, 'destroy'])->name('api.v1.categories.destroy');
});
Route::prefix('products')->group(function () {
    Route::post('store', [ProductController::class, 'store'])->name('api.v1.products.store');
    Route::post('update', [ProductController::class, 'update'])->name('api.v1.products.update');
    Route::post('destroy', [ProductController::class, 'destroy'])->name('api.v1.products.destroy');
});
Route::prefix('customers')->group(function () {
    Route::get('get_info', [CustomerController::class, 'getInfo'])->name('api.v1.customers.get_info');
    Route::post('store', [CustomerController::class, 'store'])->name('api.v1.customers.store');
    Route::post('update', [CustomerController::class, 'update'])->name('api.v1.customers.update');
    Route::post('destroy', [CustomerController::class, 'destroy'])->name('api.v1.customers.destroy');
});
Route::prefix('orders')->group(function () {
    Route::post('store', [OrderController::class, 'store'])->name('api.v1.orders.store');
    Route::get('find_product_code', [OrderController::class, 'findProductCode']); //api/orders/find_product_code
});

Route::get('/live-comments/{videoId}', [FacebookLiveController::class, 'fetchComments']); // fetch comments display json format {videoId or postId}
Route::get('/live-comments/fetch_comments/{videoId}', [FacebookLiveController::class, 'fetchCommentsToDb']); // fetch comments insert db format {videoId or postId}