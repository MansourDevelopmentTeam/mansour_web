<?php

use App\Jobs\TestBeans;
use App\Models\Users\User;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Locations\City;
use App\Models\Services\SmsService;
use Illuminate\Support\Facades\URL;
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


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get("test", function () {
//        app()->setLocale("ar");
return view('emails.order_state', ["order" => Order::find(3494)]);

//    return view('emails.stock_notifier', ["product" => \App\Models\Products\Product::find(85217),"user" => User::find(1)]);
});

Route::get("redirect", function () {
	return redirect("/failed");
});

Route::get("/users/{id}/token", function (Request $request, $id) {
    $user = User::findOrFail($id);
    $token = \JWTAuth::fromUser($user);
    return $token;
})->middleware("dev_only");

Route::get("cities", "Customer\CitiesController@index");
Route::get("categories", "Customer\CategoriesController@index");


// Route::get("testPush/{id}", "PushMessagesController@testPush");

Route::get('testurl', function () {
	dd(URL::to(''));
});
