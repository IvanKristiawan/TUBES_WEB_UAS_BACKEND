<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('barang', 'Api\BarangController@index');
Route::get('barang/{id}', 'APi\BarangController@show');
Route::post('barang', 'Api\BarangController@store');
Route::put('barang/{id}', 'Api\BarangController@update');
Route::delete('barang/{id}', 'Api\BarangController@destroy');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('review', 'Api\ReviewController@index');
    Route::get('review/{id}', 'APi\ReviewController@show');
    Route::get('reviewByIdUser/{id}', 'APi\ReviewController@showAllByIdUser');
    Route::get('reviewByIdBarang/{id}', 'APi\ReviewController@showAllByIdBarang');
    Route::post('review', 'Api\ReviewController@store');
    Route::put('review/{id}', 'Api\ReviewController@update');
    Route::delete('review/{id}', 'Api\ReviewController@destroy');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('keranjang', 'Api\KeranjangController@index');
    Route::get('keranjang/{id}', 'APi\KeranjangController@show');
    Route::get('keranjangByIdUser/{id}', 'APi\KeranjangController@showAllByIdUser');
    Route::get('keranjangByIdBarang/{id}', 'APi\KeranjangController@showAllByIdBarang');
    Route::post('keranjang', 'Api\KeranjangController@store');
    Route::put('keranjang/{id}', 'Api\KeranjangController@update');
    Route::delete('keranjang/{id}', 'Api\KeranjangController@destroy');
});