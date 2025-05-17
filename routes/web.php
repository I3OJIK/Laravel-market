<?php

use App\Http\Controllers\CreateProduct;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\HomeProductList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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
Route::get('/', function(){
    return view('welcome');
});

Auth::routes();

Route::get('/yandex-suggest', 'YandexController@suggest');

// 1. Главная — список товаров
Route::get('/', function () {
    // передаём в шаблон initialId = null
    return view('welcome');
})->name('home');

// 2. Страница товара — тот же шаблон, но initialId = $id
Route::get('/product/{id}', function ($id) {
    return view('product', ['id' => $id]);
})->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', function () {
        return view('cart');
    })->name('cart.show');

    Route::get('/orders', function () {
        return view('orders');
    })->name('orders.show');

});

