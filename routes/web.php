<?php

use App\Facade\Sms;
use App\Facade\Payment;
use App\Mail\OrderCreated;
use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Products\Product;
use App\Mail\ResetUserPasswordV2;
use App\Models\Orders\Transaction;
use App\Notifications\OrderPlaced;
use App\Models\Services\SmsService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
   return view('welcome');
});