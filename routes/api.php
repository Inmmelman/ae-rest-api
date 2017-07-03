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

Route::resource('products', '\App\Http\Controllers\REST\RestProductsController');
Route::patch('products/{id}/buy', '\App\Http\Controllers\REST\RestProductsController@buy');
Route::resource('vouchers', '\App\Http\Controllers\REST\RestVoucherController');
Route::resource(
	'products.vouchers',
	'\App\Http\Controllers\REST\RestProductsVouchersController',
	[
		'only' => [
			'update',
			'destroy'
		]
	]
);
Route::resource(
	'discount-tiers',
	'\App\Http\Controllers\REST\RestDiscountTiersController',
	[
		'only' => [
			'index'
		]
	]
);

