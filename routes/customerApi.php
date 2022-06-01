<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\AddressController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Webhook\OrderCallbackController;
use App\Http\Controllers\Customer\PrescriptionsController;
use App\Http\Controllers\Customer\PrescriptionCancellationReasonController;
use App\Http\Controllers\Customer\OrdersController;

// Get Website Variable Env
Route::get('configurations', 'ConfigurationController@index');

Route::get('pay/weAccept/responseCallback', [OrderCallbackController::class, 'weAcceptResponse'])->name('weaccept.callback');
Route::any('pay/paytabs/callback', [OrderCallbackController::class, 'paytabsResponse'])->name('paytabs.callback');
Route::get("orders/receipt/{transactionID}", [OrderCallbackController::class, 'masterCardResponse']);

Route::get('pay/{provider}/responseCallback', 'OrdersController@responseCallBack');
Route::post('pay/{provider}/processesCallback', 'OrdersController@processesCallBack');
// authentication and registraion api's
Route::post("auth", "AuthController@login");
Route::post("auth/logout", "AuthController@logout");
Route::post("auth/guest", "AuthController@guest");
Route::post("auth/signup", "AuthController@register");
Route::post("auth/social", "AuthController@socialAuth");
Route::post("auth/social_signup", "AuthController@socialRegister");

// forget password api's
Route::post("auth/forget_password", "AuthController@forgetPassword");
Route::post("auth/validate_code", "AuthController@validateCode");
Route::post("auth/reset_password", "AuthController@resetPassword");

// Forget password api's with phone
Route::post("auth/phone_forget_password", "AuthController@forgetPasswordWithPhone");
Route::post("auth/phone_validate_code", "AuthController@validateCodeWithPhone");
Route::post("auth/phone_reset_password", "AuthController@resetPasswordWithPhone");

Route::post("auth/forget_password_v2", "AuthController@forgetPasswordV2");
Route::post("auth/reset_password_v2", "AuthController@resetPasswordV2");

Route::post("newsletter", "AuthController@subscribeNewsletter");
Route::post("contact_us", "AuthController@contactUs");

Route::post("affiliates/request", "AffiliateRequestsController@store");
Route::get("affiliate/links/history", "AffiliateLinksController@storeHistory");

// addresses api's
Route::post("profile/addresses", [AddressController::class, 'store'])->name('profile.addresses.store');

Route::get("test", "\App\Http\Controllers\TestController");
Route::post('test', "\App\Http\Controllers\TestController");

Route::get("home2", "HomeController@index");
Route::get("home/initialize", "HomeController@initialize");
Route::get("products/search", "ProductsController@search");
Route::post("products/search", "ProductsController@search_products");
Route::get("products/home", "ProductsController@home");
Route::get("categories/products/{id}", "CategoriesController@getProducts");

// Medical
Route::post("prescriptions", "PrescriptionsController@store");

// Order payment view
// Route::get("orders/payment-view/{transactionID}", "OrdersController@paymentView");
Route::get("orders/payment-view/{transaction}", [CheckoutController::class, 'show']);

Route::get("orders/qnb-simplify/receipt/{transactionID}", "OrdersController@orderQnbSimplifyReceipt");
// Orders api's
Route::post("orders/check_promo_v2", "OrdersController@checkPromoV2")->name('order.checkPromo');
Route::post("orders/validate_cart", "OrdersController@validateCart");
Route::any("orders/delivery_fees", "OrdersController@getDeliveryFees");
Route::post("orders", [CheckoutController::class, 'store'])->middleware(['RestrictIp']);
// Route::post("orders", "OrdersController@createOrder")->middleware(['active', 'RestrictIp']);
Route::get("guest/orders/{id}", "OrdersController@guestShow");

Route::get('settings', "SettingsController@index");

// Home sections
Route::get("home/ads", "HomeController@ads");
Route::get("home/sections", "HomeController@sections");
Route::get("home/custom-ads", "HomeController@customAds");
Route::get("home/menu", "MenuController");

Route::get("branches", "BranchController@index");

Route::get("pages", "PageController@index");
Route::get("pages/{slug}", "PageController@show");


####

Route::get("ads", "AdsController@index");
Route::get("stores", "StoresController@getAllStores");
Route::get("lists/{id}", "ListsController@index");


Route::group(["middleware" => ["jwt.auth", "active"]], function () {
    Route::group(["middleware" => "useSession"], function () {
        Route::get("orders/pay_order", "OrdersController@payOrder");
        Route::get("orders/receipt", "OrdersController@orderReceipt");

        // Route::get("orders/receipt/{transactionID}", [OrderCallbackController::class, 'masterCardResponse']);
    });
    Route::get("wallet/statistics", "WalletController@statistics");
    Route::resource("wallet", "WalletController")->only('index', 'store');

    Route::resource("affiliate/links", "AffiliateLinksController")->only('index', 'store', 'update');




    Route::get("notifications", "NotificationsController@index");
    Route::post("notifications/read", "NotificationsController@markRead");

    Route::get('rewards', "RewardsController@getRewards");
    Route::post('rewards/redeem', "RewardsController@redeemReward");

    // PROFILE ROUTES
    Route::get("profile/points_history", "ProfileController@getPointHistory");
    Route::get("profile", "ProfileController@getProfile");
    Route::post("profile/edit", "ProfileController@editProfile");
    Route::post("profile/edit_phone", "ProfileController@editPhone");
    Route::post("profile/resend_verification", "ProfileController@resendVerification");
    Route::post("profile/change_password", "ProfileController@changePassword");
    Route::post("profile/verify_phone", "ProfileController@verifyPhone");
    Route::post("profile/add_token", "ProfileController@addToken");
    
    Route::post("profile/phone-verify", [ProfileController::class, 'checkPhoneVerified'])->name('profile.phone.verify');


    // ADDRESSES ROUTES
    Route::post("profile/addresses/{id}", [AddressController::class, 'update'])->name('profile.addresses.update');
    Route::post("profile/addresses/remove/{id}", [AddressController::class, 'destroy'])->name('profile.addresses.destroy');
    Route::post("profile/addresses/primary/{id}", [AddressController::class, 'setPrimaryAddress'])->name('profile.addresses.setPrimaryAddress');

    // USER SETTINGS ROUTES
    Route::post("profile/notification_settings", "ProfileController@updateNotificationSettings");
    Route::post("profile/language_settings", "ProfileController@updateLanguageSettings");

    // PRESCRIPTTIONS ROUTES
    Route::get("prescriptions", [PrescriptionsController::class, 'index'])->name('prescriptions.index');
    Route::get("prescription_cancellation_reasons", [PrescriptionCancellationReasonController::class, 'index'])->name('prescriptionsCancelReason.index');
    Route::post("prescriptions/{id}/cancellation", [PrescriptionsController::class, 'CancelPrescription'])->name('prescriptions.CancelPrescription');


    // PRODUCTS ROUTES
    Route::get("products/comparisons", "ProductsController@myComparisons");
    Route::post("products/set_compare/{id}", "ProductsController@setCompare");
    Route::post("products/remove_compare/{id}", "ProductsController@removeCompare");
    Route::post("products/set_products_compare", "ProductsController@setProductsCompare");
    Route::post("products/remove_products_compare", "ProductsController@removeProductsCompare");
    Route::get("products/favourites", "ProductsController@myFavourites");
    Route::get("products/top_promotions", "ProductsController@topPromotions");
    Route::get("products/most_bought", "ProductsController@mostBought");

    // FAVORITE PRODUCTS ROUTES
    Route::post("products/favourite/{id}", "ProductsController@favourite");
    Route::post("products/add_products_favourite", "ProductsController@addProductsToFavourite");
    Route::post("products/remove_favourites", "ProductsController@removeAllFavourites");
    Route::post("products/unfavourite/{id}", "ProductsController@unfavourite");
    Route::post("products/notify/{id}", "ProductsController@notifyAvailability");


    Route::post("products/review", "ProductReviewsController@addRate");

    // Orders api's

    Route::get("orders", "OrdersController@index");

    Route::get("orders/{id}", "OrdersController@show");
    Route::post("orders/check_promo", "OrdersController@checkPromo");



    Route::post("orders/rate/{id}", "OrdersController@rateOrder");
    Route::post("orders/cancel/{id}", "OrdersController@cancelOrder");
    Route::post("orders/edit_late/{id}", "OrdersController@editLateSchedule");
    Route::post("orders/cancel_late/{id}", "OrdersController@cancelLateSchedule");
    Route::post("orders/edit_schedule/{id}", "OrdersController@editSchedule");
    Route::post("orders/cancel_schedule/{id}", "OrdersController@cancelSchedule");
    Route::post("valu/get_plans", "ValuController@getPlans");
    Route::post("valu/verify", "ValuController@verifyCustomer");
    Route::resource('carts', 'CartController');
    Route::get("order_cancellation_reasons", "OrderCancellationReasonController@index");


    Route::post("upload", "UploadsController@upload");
    Route::post("clone-guest-products", "ProductsController@cloneGuestProduct");

    Route::get('purcahseTargets', [OrdersController::class, 'purcahseTargets']);
});

Route::get("products/{id}", "ProductsController@show");
Route::post('register/request', [\App\Http\Controllers\Admin\CustomerRequestController::class, 'store']);
