<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\AuthController;

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



Route::get('/test', function() {
    return response()->json(['status' => 'working']);
});

Route::group([

    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('/login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group([

    'namespace' => 'App\Http\Controllers\Api',
    'middleware' => 'jwt.auth',

], function () {
    Route::get('/cart',        [CartController::class, 'index']);   // Получить корзину
    Route::post('/cart',       [CartController::class, 'store']);   // Добавить товар
    Route::patch('/cart/{id}', [CartController::class, 'update']);  // Изменить количество
    Route::delete('/cart/{id}',[CartController::class, 'destroy']); // Удалить товар
    Route::delete('/cart',     [CartController::class, 'clear']);   // Очистить корзину
});