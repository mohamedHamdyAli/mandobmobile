<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\ChatController;

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

Route::post('register',[UserController::class, 'register']);
Route::post('login',[UserController::class,'login']);
Route::post('otp',[UserController::class,'loginWithOtp']);
Route::get('all-zone', [ActivityController::class, 'get_zone']);
Route::get('about', [SettingsController::class, 'get_about']);
Route::get('privacy', [SettingsController::class, 'get_privacy']);
Route::get('terms', [SettingsController::class, 'get_terms']);
Route::get('all-veichle', [ActivityController::class, 'get_veichle']);
Route::get('all-veichle-brand', [DriverController::class, 'get_vechile_brand']);
Route::get('all-veichle-color', [DriverController::class, 'get_vechile_color']);
Route::get('all-veichle-model', [DriverController::class, 'get_vechile_model']);

Route::post('driver-register',[DriverController::class, 'driver_register']);
Route::post('driver-login',[DriverController::class,'driver_login']);
Route::post('driver-otp',[DriverController::class,'driver_loginWithOtp']);
Route::post('update-driver-device-token',[DriverController::class,'update_device_token']);


Route::middleware(['auth:sanctum', 'localization'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api','localization']], function () {
    // Address Route
    Route::get('address', [AddressController::class, 'get_address']);
    Route::post('address',[AddressController::class, 'address_store']);
    Route::put('address/{id}',[AddressController::class, 'address_update']);
    Route::get('address/{id}',[AddressController::class, 'address_show']);
    Route::delete('address/delete/{id}',[AddressController::class, 'address_destroy']);

    // Order Route
    Route::post('total', [OrderController::class, 'total_amount']);
    Route::get('order', [OrderController::class, 'index']);
    Route::get('order-home', [OrderController::class, 'order_home']);
    Route::get('order-status', [OrderController::class, 'get_order']);
    Route::get('order-pending', [OrderController::class, 'get_pending_order']);
    Route::get('order-upcoming', [OrderController::class, 'get_upcoming_order']);
    Route::get('order-delivered', [OrderController::class, 'get_delivered_order']);
    Route::get('order-acceot', [OrderController::class, 'get_accept_order']);
    Route::get('order-ongoing', [OrderController::class, 'get_ongoing_order']);
    Route::get('order-cancel', [OrderController::class, 'get_cancel_order']);
    Route::get('order-pending-count', [OrderController::class, 'get_order_count']);
    Route::get('order-cancellation', [OrderController::class, 'get_cancellation_details']);
    Route::post('order',[OrderController::class, 'store']);
    Route::put('order/{id}',[OrderController::class, 'update']);
    Route::put('order-accept/{id}',[OrderController::class, 'driver_accept']);
    Route::put('order-cancel/{id}',[OrderController::class, 'cancel_order']);
    Route::get('order/{id}',[OrderController::class, 'show']);
    Route::post('order-search',[OrderController::class, 'search_by_id']);
    Route::get('driver-order-details/{id}',[OrderController::class, 'get_driver_order_details']);
    Route::delete('order/delete/{id}',[OrderController::class, 'destroy']);

    // user Route
    Route::get('user-profile',[UserController::class, 'show']);
    Route::get('user-wallet',[UserController::class, 'get_wallet_user']);
    Route::post('logout',[UserController::class,'logout']);
    Route::post('user-update',[UserController::class,'update_profile']);
    Route::post('driver-rate-user',[UserController::class,'driver_rate']);
    Route::post('send-notificationr-user/{id}',[UserController::class,'sendNotificationrToUser']);
    Route::post('update-device-token',[UserController::class,'update_device_token']);

    //Get Routes
    Route::get('all-activity', [ActivityController::class, 'get_activity']);


    Route::post('notification-list',[NotificationController::class,'notificationList']);
    Route::get('notification-list-user',[NotificationController::class,'view_notification_user']);
    Route::post('complaints',[SettingsController::class,'store_complaints']);

    //chat
    Route::post('user-send-message',[ChatController::class,'user_message']);
    Route::post('update-user-read',[ChatController::class,'update_user_read']);
    Route::get('user-get-message', [ChatController::class, 'get_user_message']);
    Route::get('driver-get-chat', [ChatController::class, 'get_driver_chat']);


});
Route::group(['middleware' => ['auth:driver','localization']], function () {
    Route::get('driver-profile',[DriverController::class, 'driver_show']);
    Route::get('get-driver-service',[DriverController::class, 'get_driver_service_location']);
    Route::get('get-vechile-informations',[DriverController::class, 'get_vechile_informations']);
    Route::post('driver-update',[DriverController::class,'update_driver_profile']);
    Route::post('driver-profie-update',[DriverController::class,'driver_profile']);
    Route::post('driver-order-accept',[DriverController::class,'driver_order_accept']);
    Route::post('driver-order-cancel',[DriverController::class,'driver_order_cancel']);
    Route::post('driver-order-delivered',[DriverController::class,'driver_order_delivered']);
    Route::post('driver-rate',[DriverController::class,'driver_rate']);
    Route::get('get-order-zone',[DriverController::class, 'get_order_zone']);
    Route::get('get-driver-order-status',[DriverController::class, 'get_driver_order_status']);
    Route::get('get-wallet-driver',[DriverController::class, 'get_wallet_driver']);
    Route::get('get-driver-order-accept',[DriverController::class, 'get_driver_order_accept']);
    Route::get('get-driver-order-completed',[DriverController::class, 'get_driver_order_completed']);
    Route::get('get-driver-order-details-completed',[DriverController::class, 'get_driver_order_details_completed']);
    //chat
    Route::post('update-driver-read',[ChatController::class,'update_driver_read']);
    Route::post('driver-send-message',[ChatController::class,'driver_message']);
    Route::get('driver-get-message', [ChatController::class, 'get_driver_message']);
    Route::get('get-user-chat', [ChatController::class, 'get_user_chat']);
    
    Route::get('notification-list-driver',[NotificationController::class,'view_notification_driver']);

});
