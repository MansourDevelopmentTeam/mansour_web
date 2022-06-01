<?php

use App\Jobs\TestBeans;
use App\Models\Locations\City;
use App\Models\Orders\Order;
use App\Models\Services\SmsService;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


	Route::post("auth", "AuthController@login");

	Route::group(["middleware" => ["jwt.auth", "role:deliverer"]], function ()
	{
		Route::get("profile/status", "ProfileController@getStatus");
		Route::post("profile/status", "ProfileController@changeStatus");
		
		Route::post("profile/token", "ProfileController@addToken");
		Route::get("profile/test_push/{id}", "ProfileController@testPush");

		// orders
		Route::get("orders", "OrdersController@index");
		Route::get("orders/history", "OrdersController@history");
		Route::post("orders/finish/{id}", "OrdersController@finishOrder");
		Route::post("orders/rate/{id}", "OrdersController@rateCustomer");
	});

