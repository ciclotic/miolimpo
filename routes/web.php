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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['as' => 'product.'], function() {
    Route::get('/', 'ProductController@index')->name('index');
    Route::get('categoria/{taxon}', 'ProductController@index')->name('category');
    Route::get('producto/{taxon}/{product}', 'ProductController@show')->name('show');
});

Route::group(['prefix' => 'cesta', 'as' => 'cart.'], function() {
    Route::get('ver', 'CartController@show')->name('show');
    Route::post('add/{product}', 'CartController@add')->name('add');
    Route::post('update/{cart_item}', 'CartController@update')->name('update');
    Route::post('remove/{cart_item}', 'CartController@remove')->name('remove');
});

Route::group(['prefix' => 'caja', 'as' => 'checkout.'], function() {
    Route::get('ver', 'CheckoutController@show')->name('show');
    Route::post('submit', 'CheckoutController@submit')->name('submit');
});

// ADMIN ROUTES

Route::group(['prefix' => 'admin/complement', 'as' => 'admin.'], function() {
    Route::post('/{main_product}/{complement_product}/{selected}', 'Admin\\ComplementController@store')->name('complement.store');
    Route::put('/{main_product}/{complement_product}/{selected}', 'Admin\\ComplementController@update')->name('complement.update');
    Route::delete('/{main_product}/{complement_product}', 'Admin\\ComplementController@remove')->name('complement.remove');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::resource('group', 'Admin\\GroupController');
});

Route::group(['prefix' => 'admin/group_product', 'as' => 'admin.'], function() {
    Route::post('/{group}/{group_product}/{order_field}/{price}/{group_modifiable}', 'Admin\\GroupProductController@store')->name('group_product.store');
    Route::put('/{group}/{group_product}/{order_field}/{price}/{group_modifiable}', 'Admin\\GroupProductController@update')->name('group_product.update');
    Route::delete('/{group}/{group_product}', 'Admin\\GroupProductController@remove')->name('group_product.remove');
});

// END ADMIN ROUTES
