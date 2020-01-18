<?php

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

Route::get('/', 'WelcomeController@create')->name('welcome');

Route::get('/authorization', 'Auth\LoginController@authorization')
    ->name('authorization');


Auth::routes(['register' => false, 'reset' => false ]);

Route::get('/products/{title}-{id}', 'ProductsController@show')
    ->name('products.show');


Route::middleware('auth')->group(function() {

    Route::get('/products/create', 'ProductsController@create')
        ->name('products.create');

    Route::post('/products', 'ProductsController@store')
        ->name('products.store');

});

Route::middleware('auth')
->namespace('Products')
->prefix('products')
->group(function() {

    Route::post('/purchases', 'PurchasesController@store')
        ->name('products.purchases.store');

});

Route::middleware('auth')
->namespace('Users')
->prefix('users')
->group(function() {

    Route::get('/{user}/purchases', 'PurchasesController@index')
        ->name('users.purchases.index');

    Route::get('/{user}/products', 'ProductsController@index')
        ->name('users.products.index');

});

Route::group([
    'namespace' => 'Categories',
    'prefix' => 'categories'
], function() {

    Route::get('/{title}-{id}/products', [
        'uses' => 'ProductsController@index',
        'as' => 'categories.products.index'
    ]);

});

Route::get('/home', 'HomeController@index')
    ->name('home');



