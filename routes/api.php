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

Route::group(['middleware' => 'auth.very_basic'], function () {
    //Test
    Route::post('/test', 'API\TestController@index');
    Route::post('/test-stock', 'API\TestController@stock');
    //My Profile
    Route::post('/my-profile', 'API\UserController@myProfile');
    //Edit Profile
    Route::post('/edit-profile', 'API\UserController@editProfile');
    //Registration
    Route::post('/signup', 'API\SignupController@index');
    //Verify OTP
    Route::post('/verify-otp', 'API\SignupController@verifyOTP');
    //Create PIN
    Route::post('/create-pin', 'API\SignupController@createPIN');
    //Forgot PIN
    Route::post('/forgot-pin', 'API\SignupController@forgotPIN');
    //Change PIN
    Route::post('/change-pin', 'API\SignupController@changePIN');
    //Login
    Route::post('/app-login', 'API\LoginController@index');
    //Store Locations
    Route::post('/store-locations', 'API\LocationController@index');
    //Dashboard
    Route::post('/dashboard', 'API\DashboardController@index');
    //Shopping List
    Route::post('/shopping-list', 'API\ShoppingListController@index');
    //Add Shopping List
    Route::post('/add-shoppinglist', 'API\ShoppingListController@add');
    //Delete Shopping List
    Route::post('/delete-shoppinglist', 'API\ShoppingListController@delete');
    Route::post('/remove-shoppinglist', 'API\ShoppingListController@remove');
    //Add Feedback
    Route::post('/add-feedback', 'API\FeedbackController@add');
    //Shelf Offers
    Route::post('/shelf-offers', 'API\ShelfController@offers');
    //Locate Product
    Route::post('/locate-product', 'API\ProductController@locate');
    //Best Price
    Route::post('/best-price', 'API\ProductController@bestPrice');
    //Notifications
    Route::post('/notifications', 'API\NotificationController@index');
    //Product List
    Route::post('/products', 'API\ProductController@index');
    //Product Search
    Route::post('/product-search', 'API\ProductController@search');
    Route::post('/product-search-category', 'API\ProductController@searchInCategory');
    //Product Categories
    Route::post('/product-categories', 'API\ProductController@categories');
    //Product Categories
    Route::post('/product-details', 'API\ProductController@details');
    //cart
    Route::post('/cart', 'API\CartController@index');
    Route::post('/cart-badge', 'API\CartController@badge');
    Route::post('/cart-add', 'API\CartController@add');
    Route::post('/cart-delete', 'API\CartController@destroy');
    Route::post('/cart-empty', 'API\CartController@empty');
    Route::post('/checkout', 'API\CartController@checkout');
    //address
    Route::post('/addresses', 'API\AddressController@index');
    Route::post('/address-add', 'API\AddressController@add');
    Route::post('/address-default', 'API\AddressController@default');
    //orders
    Route::post('/my-orders', 'API\OrderController@myOrders');
    Route::post('/order-details', 'API\OrderController@orderDetails');
    Route::post('/place-order', 'API\OrderController@placeOrder');
    // Get Store
    Route::post('/getstore', 'API\LocationController@getStore');
    // Pickup time
    Route::post('/pickuptime', 'API\LocationController@pickupTime');

    // Route::post('/restaurentlocator', 'API\RestaurentFindController@RestuarentFinder');
});

Route::post('transaction-status','API\PaymentController@transactionStatus');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('user-signup','api\APIRegisterController@UserRegister');
Route::post('trainer-signup','api\APIRegisterController@TrainerRegister');
Route::post('dietician-signup','api\APIRegisterController@DieticianRegister');

Route::post('user-otp-verify','api\APIVerifyController@UserOtpVerify');
Route::post('trainer-otp-verify','api\APIVerifyController@TrainerOtpVerify');
Route::post('dietician-otp-verify','api\APIVerifyController@DieticianOtpVerify');

Route::post('user-profile','api\APIProfileController@UserProfile');
Route::post('trainer-profile','api\APIProfileController@TrainerProfile');
Route::post('dietician-profile','api\APIProfileController@DieticianProfile');

Route::post('user-edit-profile','api\APIEditProfileController@UserEditProfile');
Route::post('trainer-edit-profile','api\APIEditProfileController@TrainerEditProfile');
Route::post('dietician-edit-profile','api\APIEditProfileController@DieticianEditProfile');

Route::post('user-update-profile','api\APIUpdateProfileController@UserUpdateProfile');
Route::post('trainer-update-profile','api\APIUpdateProfileController@TrainerUpdateProfile');
Route::post('dietician-update-profile','api\APIUpdateProfileController@DieticianUpdateProfile');


Route::post('login','api\APILoginController@login');
Route::post('change-password','api\APIChangePasswordController@ChangePassword');

Route::post('category','api\CategoryController@category');

Route::post('/restaurentlocator', 'API\RestaurentFindController@RestuarentFinder');