<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['auth:api', 'cors'], 'prefix' => 'v1'], function () {

  Route::get('/server', 'v1\ServerController@index');
  Route::get('/server/{id}', 'v1\ServerController@read');
  Route::post('/server', 'v1\ServerController@create');
  Route::put('/server/{id}', 'v1\ServerController@update');
  Route::delete('/server/{id}', 'v1\ServerController@destroy');

  Route::get('/ssh', 'v1\SSHController@index');
  Route::get('/ssh/{id}', 'v1\SSHController@read');
  Route::post('/ssh', 'v1\SSHController@create');
  Route::delete('/ssh/{id}', 'v1\SSHController@destroy');

  Route::get('/vpn', 'v1\VPNController@index');
  Route::get('/vpn/{id}', 'v1\VPNController@read');
  Route::post('/vpn', 'v1\VPNController@create');
  Route::delete('/vpn/{id}', 'v1\VPNController@destroy');

  Route::get('/dns', 'v1\DNSController@index');
  Route::post('/dns', 'v1\DNSController@create');
  Route::delete('/dns/{id}', 'v1\DNSController@destroy');

  Route::get('/coupon', 'v1\CouponController@index');
  Route::get('/coupon/{id}', 'v1\CouponController@read');
  Route::post('/coupon', 'v1\CouponController@create');
  Route::post('/coupon/reedem', 'v1\CouponController@reedem');
  Route::delete('/coupon/{id}', 'v1\CouponController@destroy');

  Route::get('/seller', 'v1\SellerController@index');
  Route::post('/seller', 'v1\SellerController@create');
  Route::delete('/seller/{id}', 'v1\SellerController@destroy');


  // API Below is private API with double layer authentication.

  
});

Route::group(['prefix' => 'v1/private', 'middleware' => ['cors']], function(){
      Route::post('/login', 'v1\PrivateController@login');
});
