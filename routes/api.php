<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::group(['middleware' => ['authCustom']], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('getAllUsers', 'AuthController@getAllUsers');
    Route::post('refreshToken', 'AuthController@refreshToken');
    Route::get('getUser', 'AuthController@getUser');
    Route::get('getAccountByUser/{id}', 'AuthController@getAccountByUser');
    Route::post('createAccountByUser', 'AuthController@createAccountByUser');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['authCustom'], 'namespace' => 'Api\v1'], function () {
    Route::resource('products', 'ProductController');
    Route::get('getProductByCategory/{id}', 'ProductController@getProductByCategory');
    Route::resource('categories', 'CategoriesController');
    Route::get('getListProductByCategory/{id}', 'CategoriesController@getListProductByCategory');
});

