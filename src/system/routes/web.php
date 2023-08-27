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



Route::get('/_cronsjob', 'CronsController@index');

Route::get('/install', function(){
	return view('install');
})->middleware('installMiddleware')->name('install');
Route::post('/install', 'InitController@install' )->name('install');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'feature-middleware'], function(){
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');
});

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => 'feature-middleware'], function() {
	Route::post('/vpn/edit/{id}', 'AccountController@editVPN');
	Route::post('/vpn/edit/', 'AccountController@doEditVPN');
});

// admin routes
Route::group(['middleware' => ['auth', 'adminMiddleware']], function() {
	
	// non featurable route
	Route::get('/admin', 'AdminController@index');
	Route::get('/server/add', 'ServerController@addNew');
	Route::post('/server/delete/{id}', 'ServerController@delete');
	Route::get('/server/list', 'ServerController@list_server')->name('server.list');
	Route::get('/server/add/{id}', 'ServerController@success');
	Route::post('/addserver', 'ServerController@create');
	Route::post('/server/setting/{id}', 'ServerController@setting');
	Route::post('/server/edit', 'ServerController@edit');
	Route::get('/info/create', 'InfoController@getCreate');
	Route::post('/info/publish', 'InfoController@publish');
	Route::get('/info/list', 'InfoController@list_info');
	Route::post('/info/delete/{id}', 'InfoController@delete');
	Route::get('/info/edit/{id}', 'InfoController@edit');
	Route::post('/info/edit', 'InfoController@editPost');
	Route::post('/info/publish/{id}', 'InfoController@publishInfo');
	Route::post('/info/unpublish/{id}', 'InfoController@unpublishInfo');
	Route::post('/admin/change-details', 'AdminSettingController@changeDetails');
	Route::post('/admin/change-website-details', 'AdminSettingController@changeWebsiteDetails');
	Route::post('/admin/change-message', 'AdminSettingController@changeMessage');
	Route::get('/admin/features', 'AdminSettingController@features');
	Route::post('/admin/features/enable/{id}', 'AdminSettingController@enableFeature');
	Route::post('/admin/features/disable/{id}', 'AdminSettingController@disableFeature');
	Route::post('/deposit', 'CouponController@deposit');
	
	Route::group(['middleware' => 'feature-middleware'], function() {
		Route::post('/vpn/delete/{id}', ['uses' => 'AccountController@deleteVPN']);
	});


	// dns
	Route::group(['middleware' => 'feature-middleware'], function(){
		Route::get('/dns/add', 'ZoneController@index');
		Route::post('/dns/add', 'ZoneController@add');
		Route::post('/dns/addmanual', 'ZoneController@addmanual');
		Route::post('/dns/remove', 'ZoneController@remove');
	});	

	// coupon
	Route::group(['middleware' => 'feature-middleware'], function() {
		Route::post('/coupon', 'CouponController@generate');
		Route::get('/coupon/create', 'CouponController@index');
		Route::get('/coupon/generate-number', function () {
			return response()->json([
				'coupon' => strtoupper(str_random(20)),
			]);
		});
		Route::post('/coupon/generate', 'CouponController@create');
		Route::post('/coupon/remove', 'CouponController@remove');
	});
	
	// reseller
	Route::group(['middleware' => 'feature-middleware'], function() {
		Route::get('/reseller/create', 'ResellerController@index');
		Route::post('/reseller/create', 'ResellerController@create');
		Route::post('/reseller/balance/{id}', 'ResellerController@addBalance');
		Route::post('/reseller/delete/{id}', 'ResellerController@delete');
		Route::get('/reseller/list', 'ResellerController@list_reseller');
		Route::post('/reseller/edit/{id}', 'ResellerController@edit');
		Route::post('/reseller/edit', 'ResellerController@change');
		Route::post('/reseller/lock/{id}', 'ResellerController@lock');
		Route::post('/reseller/unlock/{id}', 'ResellerController@unlock');
		Route::post('/reseller/suspend/{id}', 'ResellerController@suspend');
		Route::post('/reseller/unsuspend/{id}', 'ResellerController@unsuspend');
	});

});

// global routes
Route::group(['middleware' => ['web','authMiddleware']], function(){
	// etc
	Route::get('/', 'MainController@index');
	Route::get('/server', 'ServerController@index');
	Route::post('/service/dropbear/repair', 'ServiceController@repairDropbear');
	Route::post('/service/dropbear/test', 'ServiceController@testDropbear');
	Route::post('/service/squid/repair', 'ServiceController@repairSquid');
	Route::post('/service/squid/test', 'ServiceController@testSquid');
	Route::post('/service/openvpn/repair', 'ServiceController@repairOpenVPN');
	Route::post('/service/openvpn/test', 'ServiceController@testOpenVPN');
	Route::post('/service/badvpn/test', 'ServiceController@testBadVPN');

	Route::group(['middleware' => 'feature-middleware'], function(){
		Route::get('/vpn/list', 'AccountController@listVPN');
		Route::get('/vpn/create', 'AccountController@indexVPN');
		Route::get('/vpn/create/{ip}', ['uses' => 'AccountController@vpn']);
		Route::post('/vpn/create', 'AccountController@createVPN');
		Route::post('/vpn/lock/{id}', ['uses' => 'AccountController@lockVPN']);
		Route::post('/vpn/unlock/{id}', ['uses' => 'AccountController@unlockVPN']);
		Route::post('/vpn/password/{id}', ['uses' => 'AccountController@changeVPNPassword']);
		Route::get('/vpn/cert', 'CertController@all');
		Route::get('/vpn/cert/add', 'CertController@add');
		Route::post('/vpn/cert/upload', 'CertController@upload');
		Route::post('/vpn/cert/delete/{id}', 'CertController@deleteCert');
		Route::get('/vpn/cert/{ip}', 'CertController@byIp');
		Route::post('/vpn/editactive/{id}', 'AccountController@editActiveVPN');
		Route::post('/vpn/editactive', 'AccountController@doEditActiveVPN');

	});
	
	Route::group(['middleware' => 'feature-middleware'], function() {
		Route::get('/dns/create', 'ZoneController@create');
		Route::post('/dns/create', 'ZoneController@doCreate');
		Route::get('/dns/list', 'ZoneController@list_zone');
		Route::post('/dns/delete', 'ZoneController@delete');
	});

	Route::group(['middleware' => 'feature-middleware'], function() {
		Route::get('/tickets', 'TicketController@index');
		Route::get('/tickets/create', 'TicketController@create');
		Route::post('/tickets/create', 'TicketController@store');
		Route::get('/tickets/{id}', 'TicketController@view');
		Route::post('/tickets/comments', 'TicketController@addComment');
		Route::post('/tickets/close', 'TicketController@close');
	});

	// profile
	Route::get('/profile', 'UserController@index');
	Route::post('/profile/change-image', 'UserController@changeImage');
	Route::post('/profile/change-details', 'UserController@changeDetails');

	// monitor
	Route::get('/server/monitor', 'ServerController@doMonitor');
	Route::post('/server/monitor/{ip}', 'ServerController@monitor');

	Route::get('/info/{slug}', 'InfoController@show');
	Route::get('/information', 'InfoController@showList');
	Route::post('/reedem', 'InfoController@reedem');

});
