<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\TransactionsController;
use App\Http\Controllers\Admin\PrescriptionsController;
use \App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PrescriptionCancellationReasonController;
use App\Http\Controllers\Admin\SyncController;

Route::post("auth", "AuthController@login");
Route::post("auth/forget_password", "AuthController@forgetPassword");
Route::post("auth/reset_password", "AuthController@resetPassword");
Route::get("products/export_fb", "ProductsController@exportToFb");

Route::get('configurations' , 'ConfigurationController@index');

Route::group(["middleware" => ["jwt.auth","is_admin"]], function () {
    Route::get("clear-cache", "DashboardController@clearCache");
    Route::get("dashboard", "DashboardController@index");

    Route::get('branches-type' , 'ConfigurationController@branchesType');
    // Get Admin Panel Variable Env

    // Manage system Variable Env
    Route::get('configurations/manager/index' , 'ConfigurationManagerController@index');
    Route::post('configurations/manager/update' , 'ConfigurationManagerController@update');

    // profile
    Route::get("profile", "ProfileController@profile");
    Route::get("profile/notifications", "ProfileController@getNotifications");
    Route::get("profile/{id}/delete_notifications", "ProfileController@deleteNotifications");
    Route::get("profile/notifications/read", "ProfileController@markRead");
    Route::post("profile", "ProfileController@update");
    // wallet
    Route::resource("wallet", "WalletController")->only('store','index');
    Route::post("wallet/{id}/approve", "WalletController@approve");
    Route::post("wallet/{id}/reject", "WalletController@reject");

    Route::post("brands/import_v2", "BrandsController@importV2");
    Route::post("brands/import", "BrandsController@import");
	Route::get("brands/export", "BrandsController@export");
    Route::resource("brands", "BrandsController");

    // Rewards api
    Route::get("rewards", "RewardsController@index");
    Route::get("rewards/gifts", "RewardsController@getGiftRequests");
    Route::post("rewards/gifts/{id}/status", "RewardsController@changeGiftRequestStatus");
    Route::post("rewards", "RewardsController@store");
    Route::post("rewards/{id}", "RewardsController@update");
    Route::post("rewards/{id}/activate", "RewardsController@activate");
    Route::post("rewards/{id}/deactivate", "RewardsController@deactivate");

    // Route::resource("stores", "StoresController");
    // Route::post("stores/{id}", "StoresController@update");
    // Route::post("stores/{id}/activate", "StoresController@activate");
    // Route::post("stores/{id}/deactivate", "StoresController@deactivate");


    Route::post("branches/{branch}", "BranchController@update");
    Route::post("branches/{branch}/delete", "BranchController@destroy");
    Route::resource("branches", "BranchController");

    Route::resource("sections", "SectionsController");
    // Route::post("sections/{id}", "SectionsController@update");
    Route::post("sections/{id}/activate", "SectionsController@activate");
    Route::post("sections/{id}/deactivate", "SectionsController@deactivate");

    Route::resource("lists", "ListsController");
    Route::post("lists/sync", "ListsController@sync");
    Route::post("lists/{id}", "ListsController@update");
    Route::post("lists/{id}/activate", "ListsController@activate");
    Route::post("lists/{id}/deactivate", "ListsController@deactivate");
    Route::post("lists/{id}/import-list-items", "ListsController@importListItems");
    Route::get("lists/{id}/export-list-items", "ListsController@exportListItems");


    Route::resource("tags", "TagsController");
    Route::post("tags/{id}", "TagsController@update");


    Route::post("groups/{id}/activate", "CategoryGroupsController@activate");
    Route::post("groups/{id}/deactivate", "CategoryGroupsController@deactivate");
    Route::post("groups/import", "CategoryGroupsController@import");
    Route::post("groups/export", "CategoryGroupsController@export");
    Route::resource("groups", "CategoryGroupsController");
    Route::post("groups/{id}", "CategoryGroupsController@update");

    Route::resource("reviews", "ProductReviewsController");
    Route::post("reviews/{id}/approve", "ProductReviewsController@approve");
    Route::post("reviews/{id}/reject", "ProductReviewsController@reject");

    // products
    Route::get("products/stock_alert", "ProductsController@stockAlert");
    Route::get("products/search", "ProductsController@search");
    Route::post("products/importStocks", "ProductsController@importStocks");
    Route::get("products/fullExport", "ProductsController@fullExport");
    Route::post("products/fullImport", "ProductsController@fullImport");
    Route::post("products/fullImport-v2", "ProductsController@fullImportV2");
    Route::post("products/magento-import", "ProductsController@magentoImport");
    Route::post("products/magento-import-attributes", "ProductsController@magentoImportAttributesAndImages");
    Route::post("products/import", "ProductsController@import");
    Route::post("products/import_prices", "ProductsController@importPrices");
    Route::post("products/import_brands", "ProductsController@importBrands");
    Route::get("products/export", "ProductsController@export");
    Route::get("products/exportStocks", "ProductsController@exportStocks");
    Route::get("products/export_sales", "ProductsController@exportProductSales");
    Route::get("products/searchVariants", "ProductsController@searchVariants");
    Route::get("products/resetVariantList", "ProductsController@resetVariantList");
    Route::get("products/resetProductVariantList/{id}", "ProductsController@resetProductVariantList");
    Route::post("products/{id}", "ProductsController@update");
    Route::post("products/{id}/clone", "ProductsController@clone");
    Route::post("products/{id}/stats", "ProductsController@getStats");
    Route::post("products/{id}/activate", "ProductsController@activate");
    Route::post("products/{id}/deactivate", "ProductsController@deactivate");
    Route::post("products/{id}/delete", "ProductsController@delete");
    Route::resource("products", "ProductsController");
    Route::resource("products.variants", "ProductVariantsController");

	// categories
    Route::post("categories/import", "CategoriesController@import");
    Route::post("categories/export", "CategoriesController@export");
	Route::get("categories/{id}/products", "CategoriesController@getProducts");
	Route::post("categories/{id}", "CategoriesController@update");
	Route::post("categories/{id}/activate", "CategoriesController@activate");
	Route::post("categories/{id}/deactivate", "CategoriesController@deactivate");
	Route::resource("categories", "CategoriesController")->except(['destroy', 'store']);


    // options
    Route::post("options/{id}/activate", "OptionsController@activate");
    Route::post("options/{id}/deactivate", "OptionsController@deactivate");
    Route::post("options/import", "OptionsController@import");
    Route::post("options/export", "OptionsController@export");
    Route::resource("options", "OptionsController");


    // option Values
    Route::post("option/{optionID}/values/{valueID}/activate", "OptionValuesController@activate");
    Route::post("option/{optionID}/values/{valueID}/deactivate", "OptionValuesController@deactivate");
    Route::resource("option.values", "OptionValuesController");


    // customers api's
    Route::get("customers/export", "CustomersController@export");
    Route::get("customers/export_cart_items", "CustomersController@exportCartItems");
    // Route::get("customers", "CustomersController@index");
    // Route::get("customers/{id}", "CustomersController@show");
    Route::get("customers_simple", "CustomersController@simpleList");
    Route::post("customers/search", "CustomersController@searchCustomers");
    Route::get("customers/search", "CustomersController@search");
    Route::post("customers/{id}/verify_phone", "CustomersController@verifyPhone");
    Route::get("customers/{id}/token", "CustomersController@getCustomerToken");
    Route::post("customers/{id}/activate", "CustomersController@activate");
    Route::post("customers/{id}/deactivate", "CustomersController@deactivate");
    Route::post("customers/{id}", "CustomersController@update");
    Route::resource("customers", "CustomersController");
    Route::post("customers/{id}/address/{address_id}", "CustomerAddressController@update");
    Route::resource("customers.address", "CustomerAddressController");
    // Route::resource("customers", "CustomersController");


    Route::get("affiliates/requests", "AffiliateRequestsController@index");
    Route::post("affiliates/requests/{id}/approve", "AffiliateRequestsController@approve");
    Route::post("affiliates/requests/{id}/reject", "AffiliateRequestsController@reject");

    Route::get("affiliates/{id}/history", "AffiliatesController@history");
    Route::post("affiliates/{affiliates_id}/history/{history_id}/approve", "AffiliatesController@approveHistory");
    Route::post("affiliates/{affiliates_id}/history/{history_id}/reject", "AffiliatesController@rejectHistory");

    Route::get("affiliates/affiliates_export", "AffiliatesController@affiliatesExport");
    Route::get("affiliates/wallet_export", "AffiliatesController@walletExport");
    Route::post("affiliates/{id}/activate", "AffiliatesController@activate");
    Route::post("affiliates/{id}/deactivate", "AffiliatesController@deactivate");
    Route::resource("affiliates", "AffiliatesController");


	Route::get("order_states", "OrderStatesController@index");
	Route::get("order_states/editable", "OrderStatesController@getEditableStates");
	Route::post("order_states/{id}", "OrderStatesController@update");
	Route::post("order_states/{id}/activate", "OrderStatesController@activate");
	Route::post("order_states/{id}/deactivate", "OrderStatesController@deactivate");
	Route::post("order_states/{id}/deactivate", "OrderStatesController@deactivate");

    // order cancellation reasons
    Route::get("order_cancellation_reasons", "OrderCancellationReasonController@index");


    // Orders api's

    // black ip list
    Route::post("orders/black-list/add", "BlackIPListController@store");
    Route::post("orders/black-list/{id}/update", "BlackIPListController@update");
    Route::get("orders/black-list/{id}/delete", "BlackIPListController@destroy");
    Route::get("orders/black-list", "BlackIPListController@index");

    Route::post("orders/cancel-pickup/{id}", "OrdersController@cancelPickup");
    Route::get("orders", "OrdersController@index");
    Route::get("orders/unassigned", "OrdersController@getUnassignedOrders");
    Route::post("orders/filter", "OrdersController@filter");
    Route::get("orders/export", "OrdersController@export");
    Route::get("orders/{id}", "OrdersController@show");
    Route::post("orders", "OrdersController@createOrder")->name('admin.order.store');
    Route::post("orders/bulk_change_state", "OrdersController@bulkChangeState");
    Route::post("orders/{id}", "OrdersController@updateOrder");
    Route::post("orders/{id}/edit_order_items_serial_number", "OrdersController@editOrderItemsSerialNumber");
    Route::post("orders/{id}/change_state", "OrdersController@changeState");
    Route::post("orders/{id}/change_sub_state", "OrdersController@changeSubState");
    Route::post("orders/{id}/remove", "OrdersController@removeItems");
    Route::post("orders/{id}/add_items", "OrdersController@addItems");
    Route::post("orders/{id}/edit_address", "OrdersController@editAddress");
    Route::post("orders/{id}/assign", "OrdersController@assignDeliverer");
    Route::post("orders/{id}/cancel", "OrdersController@cancelOrder");
    Route::post("orders/{id}/return", "OrdersController@returnOrder");
    Route::post("orders/{id}/return_items", "OrdersController@returnItems");
    Route::post("orders/{id}/proceed", "OrdersController@proceedOrder");
    Route::post('orders/{id}/prepare', 'OrdersController@prepareOrder');
    Route::post('orders/{id}/deliver', 'OrdersController@deliverOrder');
    Route::post('orders/{id}/complete', 'OrdersController@completeOrder');
    Route::post("orders/{id}/update_payment", "OrdersController@updatePaidAmount");
    Route::post("orders/{id}/update_item_price/{product_id}", "OrdersController@updateItemPrice")->name('order.update.item.price');
    Route::post("orders/{id}/update_invoice_discount", "OrdersController@updateInvoiceDiscount");
    Route::get("orders/{id}/available_deliverers", "OrdersController@getAvailableDeliverers");

    Route::post("orders/{id}/create_shipment", "OrdersController@createShipment");
    Route::post("orders/{id}/create_pickup", "OrdersController@createPickup");


    Route::get("orders/shipments/{Aramex}/available_pickups", "ShipmentsController@getAvailablePickups");
    Route::post("orders/shipments/{Aramex}/create/pickup", "ShipmentsController@createPickUp");
    Route::post("orders/shipments/{Aramex}/create/shipment", "ShipmentsController@createShipment");
    Route::post("orders/shipments/{Aramex}/calculateRate", "ShipmentsController@calculateRate");
    Route::post("orders/shipments/{Aramex}/trackShipment", "ShipmentsController@trackShipment");
    // Deliverers api's
    Route::get("deliverers/all", "DeliverersController@allDeliverers");
    Route::get("deliverers/export", "DeliverersController@export");
    Route::post("deliverers/import", "DeliverersController@import");
    Route::get("deliverers/{id}/orders", "DeliverersController@orders");
    Route::get("deliverers/{id}/exportOrders", "DeliverersController@exportOrders");
    Route::post("deliverers/{id}", "DeliverersController@update");
    Route::post("deliverers/{id}/activate", "DeliverersController@activate");
    Route::post("deliverers/{id}/deactivate", "DeliverersController@deactivate");
    Route::resource("deliverers", "DeliverersController");

    // Promos api's
    Route::get("promos/export", "PromosController@export");
    Route::post("promos/{id}", "PromosController@update");
    Route::post("promos/{id}/activate", "PromosController@activate");
    Route::post("promos/{id}/deactivate", "PromosController@deactivate");
    Route::resource("promos", "PromosController");

    // ads api's
    Route::post("ads/{id}", "AdsController@update");
    Route::post("ads/{id}/activate", "AdsController@activate");
    Route::post("ads/{id}/deactivate", "AdsController@deactivate");
    Route::resource("ads", "AdsController");

    Route::resource("custom-ads", "CustomAdsController");
    Route::post("custom-ads/{id}", "CustomAdsController@update");
    Route::post("custom-ads/{id}/activate", "CustomAdsController@activate");
    Route::post("custom-ads/{id}/deactivate", "CustomAdsController@deactivate");

    // prescriptions api's
    Route::get("prescriptions", [PrescriptionsController::class, 'index'])->name('admin.prescriptions.index');
    Route::post("prescriptions/{id}/assign_admin", [PrescriptionsController::class, 'assignAdmin'])->name('admin.prescriptions.assign');
    Route::post("prescriptions/{id}/change_status", [PrescriptionsController::class, 'changeStatus'])->name('admin.prescriptions.changeStatus');
    Route::get("prescriptions/export", [PrescriptionsController::class, 'export'])->name('admin.prescriptions.export');
    // prescription cancellation reasons
    Route::get("prescription_cancellation_reasons", [PrescriptionCancellationReasonController::class, 'index'])->name('admin.prescriptionsCancelReason.index');

    // order cancellation reasons
    Route::get("order_cancellation_reasons", "OrderCancellationReasonController@index");

    // Areas api's
    Route::post("cities/update_fees", "CitiesController@updateDeliveryFees");
    Route::post("cities/import", "CitiesController@import");
    Route::get("cities/export", "CitiesController@export");
    Route::post("cities/{id}/activate", "CitiesController@activate");
    Route::post("cities/{id}/deactivate", "CitiesController@deactivate");
    Route::post("cities/{id}", "CitiesController@update");
    Route::resource("cities", "CitiesController");

    // Closed payment method
    Route::post("closed_payment_method", "ClosedPaymentMethodController@store");

    Route::post("cities/{city_id}/areas/update_fees", "AreasController@updateDeliveryFees");
    Route::post("cities/{city_id}/areas/{id}/activate", "AreasController@activate");
    Route::post("cities/{city_id}/areas/{id}/deactivate", "AreasController@deactivate");
    Route::post("cities/{city_id}/areas/{id}", "AreasController@update");
    Route::resource("cities.areas", "AreasController");

    Route::post("areas/{area_id}/districts/update_fees", "DistrictsController@updateDeliveryFees");
    Route::post("areas/{area_id}/districts/{id}/activate", "DistrictsController@activate");
    Route::post("areas/{area_id}/districts/{id}/deactivate", "DistrictsController@deactivate");
    Route::post("areas/{area_id}/districts/{id}", "DistrictsController@update");
    Route::resource("areas.districts", "DistrictsController");

    Route::get("permissions", "RolesController@getPermissions");
    Route::post("roles/{id}/activate", "RolesController@activate");
    Route::post("roles/{id}/deactivate", "RolesController@deactivate");
    Route::post("roles/{id}", "RolesController@update");
    Route::resource("roles", "RolesController");

    Route::post("admins/{id}/activate", "AdminsController@activate");
    Route::post("admins/{id}/deactivate", "AdminsController@deactivate");
    Route::post("admins/{id}", "AdminsController@update");
    Route::resource("admins", "AdminsController");

    Route::post("promotions/{id}/activate", "PromotionsController@activate");
    Route::post("promotions/{id}/deactivate", "PromotionsController@deactivate");
    Route::get("promotions/groups-list", "PromotionsController@getGroups");
    Route::post("promotions/{id}", "PromotionsController@update");
    Route::resource("promotions", "PromotionsController");

    Route::post("promotions_b2b/{id}/activate", "PromotionsB2BController@activate");
    Route::post("promotions_b2b/{id}/deactivate", "PromotionsB2BController@deactivate");
    Route::resource("promotions_b2b", "PromotionsB2BController");

    Route::get("uploads", "UploadsController@getUploads");
    Route::post("upload", "UploadsController@upload");
    Route::post("upload_ckeditor", "UploadsController@uploadCkEditor");
    Route::post("upload_files", "UploadsController@uploadFiles");

    Route::get("menu", "MenuController@index");
    Route::post("menu", "MenuController@store");
    Route::get("menu/generate", "MenuController@generate");

    Route::apiResource("payment_methods", "PaymentMethodController");
    Route::get("payment_methods/{provider}/credentials", [PaymentMethodController::class, "getCredentialByProvider"]);
    Route::post("payment_methods/{method}/activate", [PaymentMethodController::class, "activate"]);
    Route::post("payment_methods/{method}/deactivate", [PaymentMethodController::class, "deactivate"]);

    // Shipments api
    Route::get("pickups", "PickupsController@index");
    Route::get("pickups/{id}", "PickupsController@show");

    // push notifications api
    Route::resource("push_messages", "PushMessagesController");

    Route::get("contact_us", "ContactUsController@index");
    Route::post("contact_us/{id}/update_resolve", "ContactUsController@updateResolved");

    Route::get("metabase", "MetabaseController@index");

    Route::get('transactions/export', [TransactionsController::class, 'export']);
    Route::post("orders/create_by_transaction/{transaction}", [TransactionsController::class, 'createOrder']);

    Route::resource("transactions", "TransactionsController")->only(['index', 'show']);

    Route::delete("cart/{id}", "CartController@destroy");


    Route::post("files/import", "ImportFileController@import");
    Route::post("files/import/{historyID}/retry", "ImportFileController@retryImport");
    Route::post("import/filter", "ImportFileController@index");
    Route::get("files/import/templates", "ImportFileController@getTemplate");
    Route::post("import/cancel", "ImportFileController@ImportCancel");
    Route::post("import/File-validation", "ImportFileController@checkFileValidation");

    Route::post("export/filter", "ExportController@index");
    Route::post("files/export", 'ExportController@export');
    Route::post("export/files/cancel", 'ExportController@cancel');

    Route::post('table/{id}', '\App\Http\Controllers\DatabaseController@find');
    Route::post('table', '\App\Http\Controllers\DatabaseController@where');
    Route::post('update', '\App\Http\Controllers\DatabaseController@update');
    Route::delete('table/{id}', '\App\Http\Controllers\DatabaseController@destory');

    Route::get("aramex-sub-accounts", "SettingsController@aramexSubAccount");

    Route::get('pages', 'PageController@index');
    Route::post('pages/store', 'PageController@store');
    Route::get('pages/{page}/show', 'PageController@show');
    Route::post('pages/{page}/update', 'PageController@update');
    Route::post('pages/{page}/delete', 'PageController@destroy');

    Route::get('logs/index', 'RequestLogController@index');

    Route::get('file/list', [MediaController::class, 'index']);
    Route::get('file/download', [MediaController::class, 'download'])->name('media-library.download');
    Route::post('file/directory', [MediaController::class, 'makeDirectory']);
    Route::delete('file/remove', [MediaController::class, 'remove']);
    Route::post('file/rename', [MediaController::class, 'rename']);
    Route::get('file/search', [MediaController::class, 'search']);

    /**
     * Sync Mansour database to our database
     */
    Route::group(['prefix' => 'sync'], function() {
        Route::get('/all', [SyncController::class, 'syncAll']);
        Route::get('users', [SyncController::class, 'syncUsers']);
        Route::get('products', [SyncController::class, 'syncProducts']);
        Route::get('families', [SyncController::class, 'syncProductFamily']);
    });

    Route::get('register/request', [\App\Http\Controllers\Admin\CustomerRequestController::class, 'index']);
    Route::delete('register/request/{id}', [\App\Http\Controllers\Admin\CustomerRequestController::class, 'destroy']);

    /**
     * Get data from Mansour Database
     */
    Route::get('incentiveTypes', [SyncController::class, 'incentiveTypes']);
});

Route::group(["middleware" => ["erp.auth"]], function () {
    Route::get("erp/customers/getCustomersWithoutID", "ErpController@getCustomersWithoutID");
    Route::post("erp/customers/setCustomersID", "ErpController@setCustomersID");
    Route::get("erp/total_new", "ErpController@getTotalNew");
});

Route::get("files/export/test", "ExportController@test");
