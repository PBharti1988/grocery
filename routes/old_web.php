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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/super-admin', function () {
    if (Auth::check()) {
        return view('superadmin.home');
    } else {
        return redirect()->action('LoginController@index');
    }
});
Route::get('/qrestro/{url}', 'DashBoardController@list');
Route::get('/qrestro/{url}/cart', 'DashBoardController@cart');

Route::get('/stores/', 'DashBoardController@liststores');
Route::post('/stores/', 'DashBoardController@redirect_to_store');

Route::post('/getcity/', 'DashBoardController@get_city_area_list');
Route::post('/getstore/', 'DashBoardController@get_store');


Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login']);

Route::group(['middleware' => 'auth'], function () {

    Route::resource('restaurant', 'RestaurantController');
    Route::resource('product', 'ProductController');
    Route::resource('module', 'ModuleController');
    Route::resource('role', 'RoleController');
    Route::resource('currency', 'CurrencyController');
    Route::resource('priviledge', 'PriviledgeController');
    Route::get('/restaurant/{id}/config', 'PriviledgeController@moduleConfig');
    Route::get('/restaurant/{id}/role', 'RoleController@roleConfig');
    Route::get('/restaurant/{id}/menu-copy', 'MenuCopyController@index');
    Route::post('/menu-copy', 'MenuCopyController@copyMenu');
    Route::post('/restaurant-role/{id}', 'RoleController@RestaurantRoleUpdate');

    
    //Ajax
    Route::get('restaurant-action','RestaurantController@restaurantAction');
    Route::get('module-action','ModuleController@moduleAction');
    Route::get('role-action','RoleController@roleAction');
    Route::get('currency-action', 'CurrencyController@currencyAction');
    Route::get('role-priviledge-action', 'PriviledgeController@priviledgeAction');
    Route::get('/restaurant-priviledge-action', 'PriviledgeController@restaurantPriviledgeUpdate');
    Route::get('/logout', function () {

        Auth::logout();
        return redirect('/super-admin');
    });

});

Route::group(['middleware' => 'checkAdmin'], function () {
    Route::resource('/banners', 'BannerController');
    Route::resource('/shelves', 'ShelfController');
    Route::resource('/floors', 'FloorController');
    Route::resource('/shelf-offers', 'ShelfOfferController');
    Route::post('/admin-login', 'AdminLoginController@login');
    Route::get('/admin', 'AdminDashboardController@index');
    Route::resource('/category', 'AdminCategoryController');
    Route::resource('/sub-category', 'AdminSubCategoryController');
    Route::resource('/timing', 'TimingController');
    Route::resource('/permission', 'AdminModulePrivilegeController');
    Route::resource('/storelocation', 'StoreLocationController');
    Route::post('/storelocation/cityupdate', 'StoreLocationController@cityupdate');

    Route::get('permission-update', 'AdminModulePrivilegeController@priviledgeAction');

   //Item
    Route::resource('/item', 'AdminItemController');
    Route::resource('/table', 'AdminTableController');
    Route::resource('/order', 'OrderController');
    Route::resource('/billbook', 'BillbookController');
    Route::get('/billbook/{id}/detail', 'BillbookController@billdetail');
    Route::post('/billbook/{id}/detail', 'BillbookController@billdetail');
    Route::get('/order/{id}/detail', 'OrderController@detail');
    Route::get('/search-item', 'OrderController@searchItem');
    Route::get('/add-more-to-order/{id}/{type}/{tab}', 'OrderController@addMoreToOrder');
    Route::post('/order/{id}/conclude', 'OrderController@orderconclude');
    Route::post('/acceptorder', 'OrderController@accept_order');
    Route::get('/new-table-order', 'OrderController@newtableorder');
    Route::get('/table-order', 'OrderController@tableorder');
    Route::post('/item-add-in-order/{id}/{type}/{tab}', 'OrderController@addItemToOrder');
    Route::get('/table-order/{id}', 'OrderController@tableorderdetail');
    Route::post('/chkcpn', 'OrderController@check_apply_coupon');
    Route::post('/table-order/{id}/conclude', 'OrderController@tableorderconclude');
    Route::post('/orderstatus', 'OrderController@neworder_update_status');
    Route::post('/generatebill', 'OrderController@generate_bill');
    Route::post('/get-neworder', 'OrderController@get_neworder');
    Route::resource('/admin/feedback', 'AdminFeedbackController');
    Route::resource('/card-details', 'CardDetailController');
    Route::resource('/coupon', 'CouponController');
    Route::resource('/promotion', 'PromotionController');
    Route::get('/item/{id}/addon', 'TopUpController@addTopUp');
    Route::post('/itemstatus', 'AdminItemController@item_status');
    Route::resource('/payment-config', 'PaymentConfigController');
    Route::resource('/sms-config', 'SmsConfigController');
    Route::post('/payment-detail-store', 'PaymentConfigController@PaymentDetailStore');
    Route::post('/sms-detail-store', 'SmsConfigController@SmsDetailStore');
    Route::resource('/tax', 'TaxController');
    Route::resource('/question', 'QuestionController');
    Route::resource('/addon', 'TopUpController');
    Route::resource('/language', 'LanguageController');
    Route::resource('/sms-template', 'SmsTemplateController');
    Route::post('/set-language', 'LanguageController@setlocale');
    Route::get('/order-reports', 'ReportController@index');
    Route::get('/order/{id}/order-detail', 'ReportController@orderDetail');
    Route::get('/order-export', 'ExportController@orderExport');
    Route::get('/order-export-new/{from}/{to}/{mode}', 'ExportController@orderExportCondition');

    Route::get('restaurant-seo', 'SeoController@index');
    Route::post('seo-store', 'SeoController@store');

    Route::post('/itemstatus', 'AdminItemController@item_status');

    Route::resource('/account-setting', 'AccountSettingController');
    Route::resource('/restaurant-manager', 'RestaurantManagerController');   
    Route::post('/restaurant-manager-update/{id}', 'RestaurantManagerController@update');
    Route::post('/restaurant-setting/{id}', 'AccountSettingController@saveSetting');
    Route::post('/change-password-manager/{id}', 'RestaurantManagerController@changePassword');
    Route::post('/restaurant-update/{id}', 'AccountSettingController@update');
    Route::post('/change-password-restaurant/{id}', 'AccountSettingController@changePassword');

    Route::get('/customer-reports', 'ReportController@customerReport');
    Route::get('/customer-export', 'ExportController@customerExport');
    Route::get('/customer-export-new/{from}/{to}/{mode}', 'ExportController@customerExportCondition');

    Route::get('/payment-reports', 'ReportController@paymentReport');
    Route::get('/payment-export', 'ExportController@paymentExport');
    Route::get('/payment-export-new/{from}/{to}/{mode}', 'ExportController@paymentExportCondition');
   //ajax
   Route::get('/card-action', 'CardDetailController@cardAction');
   Route::get('/question-action', 'QuestionController@questionAction');
   Route::get('/tax-action', 'TaxController@taxAction');
   Route::get('/take-away-action', 'AdminDashboardController@takeAwayAction');
   Route::get('/orderAccepting-action', 'AdminDashboardController@orderAcceptingAction');
   Route::get('/delivery-action', 'AdminDashboardController@deliveryAction');
   Route::get('/custom-price-action', 'TopUpController@addCustomPrice');
   Route::get('/restaurant-timing-action', 'TimingController@UpdateTiming');
   Route::get('/addon-enabled-action', 'TopUpController@enabledAction');
   Route::get('/addon-delete-action', 'TopUpController@deleteAction');
    Route::get('/dropdown/sub-category', 'AdminItemController@subCategory');

    //ajax for item update in orders
    Route::post('update-item-qty', 'OrderController@updateItemQty');

    Route::get('/admin-logout', function () {
        Auth::guard('restaurant')->logout();
        return redirect('/admin');
    });

    Route::get('/manager-logout', function () {
        Auth::guard('manager')->logout();
        return redirect('/admin');
    });

});

Route::post('search-restaurant', 'DashBoardController@index');

Route::get('/', 'DashBoardController@view');
Route::post('/feedback', 'DashBoardController@feedback');
Route::post('/questionform-data', 'DashBoardController@feedbackQuestion');
Route::post('/cartupdate', 'DashBoardController@cartupdate');
Route::post('/otp', 'DashBoardController@generateotp');
//Route::post('/order-details', 'DashBoardController@orderDetails');
Route::post('order-details', 'DashBoardController@orderDetails');
Route::post('get-details', 'DashBoardController@getDetails');
Route::post('add-address', 'DashBoardController@addAddresses');
Route::post('get-address', 'DashBoardController@getAddresses');
Route::post('coupan-apply', 'DashBoardController@coupanApply');
//Route::get('payment', 'PaymentController@index');
Route::get('payment', 'PaymentController@index');
Route::post('/payments', 'PaymentController@payments');
Route::get('/billpayments/{billid}', 'PaymentController@showbill');
Route::get('/invoice/{billid}', 'PaymentController@showinvoice');
Route::get('/slider/{id}', 'SliderController@index');
Route::post('charge', 'PaymentController@charge');
Route::post('chargebylink', 'PaymentController@chargebylink');
Route::get('payment-status', 'PaymentController@payu');
Route::get('/promotion-detail/{id}', 'PromotionController@promotion');
Route::post('chargebyinstant', 'PaymentController@chargebyinstant');
Route::post('/get-trackingId', 'DashBoardController@trackingId');
Route::post('/applycpn', 'BillbookController@check_apply_coupon');











/* always keep these path in last */
Route::get('/{handle}/{url}', 'DashBoardController@list_handle');
Route::post('/{handle}/{url}', 'DashBoardController@list_handle');
Route::get('/{handle}/{url}/cart', 'DashBoardController@cart_handle');
