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
Route::get('/products/create', 'CreateProduct@create');
Route::get('/product/{id}', 'CreateProduct@create')->name('product.show');

// Route::get('/product', function () {
//     // mount() вернёт объект, .html() — готовый HTML
//     return Livewire::mount('home-product-list')->html();
// })->name('products.index');


// 1. Главная — список товаров
Route::get('/', function () {
    // передаём в шаблон initialId = null
    return view('welcome', ['initialId' => null]);
})->name('home');

// 2. Страница товара — тот же шаблон, но initialId = $id
Route::get('/product/{id}', function ($id) {
    return view('welcome', ['initialId' => $id]);
})->name('product.show');

Route::get('/home', 'HomeController@index')->name('home');
