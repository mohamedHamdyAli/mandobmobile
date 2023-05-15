<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\VeichleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CanellOrderController;
use App\Http\Controllers\VehicleBrandController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleColorController;
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
    // Route::controller(App\Http\Controllers\Api\UserController::class)->group(function(){
    //     Route::get('otp/login', 'login')->name('otp.login');
    //     Route::post('otp/generate', 'generate')->name('otp.generate');
    //     Route::get('otp/verification/{user_id}', 'verification')->name('otp.verification');
    //     Route::post('otp/login', 'loginWithOtp')->name('otp.getlogin');
    // });

Route::get('/', function(){
    return redirect('admin/login');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
    Route::post('/login', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

    Route::group(['middleware' => 'adminauth'], function () {
        Route::get('home', [DashboardController::class, 'Counter'])->name('adminDashboard');
        Route::any('logout',[AdminAuthController::class, 'logout'])->name('adminlogout');
        // admin routes
        Route::get('profile/{id}', [AdminAuthController::class, 'view'])->name('admin.view');
        Route::post('profile/{id}', [AdminAuthController::class, 'update'])->name('admin.update');

        //user routes
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::get('users/create',[UserController::class, 'create'])->name('users.create');
        Route::post('users/create',[UserController::class, 'store'])->name('users.store');
        Route::get('users/edit/{id}',[UserController::class, 'create'])->name('users.edit');
        Route::get('users/show/{id}',[UserController::class, 'show'])->name('users.show');
        Route::get('users/rate',[UserController::class, 'get_user_rate'])->name('user.index.rate');
        Route::get('users/rate/{id}',[UserController::class, 'show_user_rate'])->name('users.show.rate');
        Route::delete('users/delete/{id}',[UserController::class, 'destroy'])->name('users.destroy');

        //drivers routes
        Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
        Route::get('drivers/create',[DriverController::class, 'create'])->name('drivers.create');
        Route::post('drivers/create',[DriverController::class, 'store'])->name('drivers.store');
        Route::get('drivers/edit/{id}',[DriverController::class, 'create'])->name('drivers.edit');
        Route::get('drivers/show/{id}',[DriverController::class, 'show'])->name('drivers.show');
        Route::get('drivers/wallet/{id}',[DriverController::class, 'show_wallet'])->name('drivers.wallet');
        Route::delete('drivers/delete/{id}',[DriverController::class, 'destroy'])->name('drivers.destroy');
        Route::post('drivers/delete/wallet/{id}',[DriverController::class, 'update_wallet'])->name('drivers.update_wallet');
        Route::get('drivers/rate',[DriverController::class, 'get_user_rate'])->name('drivers.index.rate');
        Route::get('drivers/rate/{id}',[DriverController::class, 'show_user_rate'])->name('drivers.show.rate');

        //Zone routes
        Route::get('zone', [ZoneController::class, 'index'])->name('zone.index');
        Route::get('zone/create',[ZoneController::class, 'create'])->name('zone.create');
        Route::post('zone/create',[ZoneController::class, 'store'])->name('zone.store');
        Route::get('zone/edit/{id}',[ZoneController::class, 'create'])->name('zone.edit');
        Route::get('zone/show/{id}',[ZoneController::class, 'show'])->name('zone.show');
        Route::delete('zone/delete/{id}',[ZoneController::class, 'destroy'])->name('zone.destroy');
        Route::post('import',[ZoneController::class,'import'])->name('zone.import');
        Route::get('export-zone',[ZoneController::class,'export_zone'])->name('zone.export');


        //activity routes
        Route::get('activity', [ActivityController::class, 'index'])->name('activity.index');
        Route::get('activity/create',[ActivityController::class, 'create'])->name('activity.create');
        Route::post('activity/create',[ActivityController::class, 'store'])->name('activity.store');
        Route::get('activity/edit/{id}',[ActivityController::class, 'create'])->name('activity.edit');
        Route::get('activity/show/{id}',[ActivityController::class, 'show'])->name('activity.show');
        Route::delete('activity/delete/{id}',[ActivityController::class, 'destroy'])->name('activity.destroy');

        //cancell routes
        Route::get('cancell', [CanellOrderController::class, 'index'])->name('cancell.index');
        Route::get('cancell/create',[CanellOrderController::class, 'create'])->name('cancell.create');
        Route::post('cancell/create',[CanellOrderController::class, 'store'])->name('cancell.store');
        Route::get('cancell/edit/{id}',[CanellOrderController::class, 'create'])->name('cancell.edit');
        Route::get('cancell/show/{id}',[CanellOrderController::class, 'show'])->name('cancell.show');
        Route::delete('cancell/delete/{id}',[CanellOrderController::class, 'destroy'])->name('cancell.destroy');

        //veichle routes
        Route::get('veichle', [VeichleController::class, 'index'])->name('veichle.index');
        Route::get('veichle/create',[VeichleController::class, 'create'])->name('veichle.create');
        Route::post('veichle/create',[VeichleController::class, 'store'])->name('veichle.store');
        Route::get('veichle/edit/{id}',[VeichleController::class, 'create'])->name('veichle.edit');
        Route::get('veichle/show/{id}',[VeichleController::class, 'show'])->name('veichle.show');
        Route::delete('veichle/delete/{id}',[VeichleController::class, 'destroy'])->name('veichle.destroy');

        //veichle brand routes
        Route::get('veichle_brand', [VehicleBrandController::class, 'index'])->name('veichle_brand.index');
        Route::get('veichle_brand/create',[VehicleBrandController::class, 'create'])->name('veichle_brand.create');
        Route::post('veichle_brand/create',[VehicleBrandController::class, 'store'])->name('veichle_brand.store');
        Route::get('veichle_brand/edit/{id}',[VehicleBrandController::class, 'create'])->name('veichle_brand.edit');
        Route::get('veichle_brand/show/{id}',[VehicleBrandController::class, 'show'])->name('veichle_brand.show');
        Route::delete('veichle_brand/delete/{id}',[VehicleBrandController::class, 'destroy'])->name('veichle_brand.destroy');

        //veichle Model routes
        Route::get('veichle_model', [VehicleModelController::class, 'index'])->name('veichle_model.index');
        Route::get('veichle_model/create',[VehicleModelController::class, 'create'])->name('veichle_model.create');
        Route::post('veichle_model/create',[VehicleModelController::class, 'store'])->name('veichle_model.store');
        Route::get('veichle_model/edit/{id}',[VehicleModelController::class, 'create'])->name('veichle_model.edit');
        Route::get('veichle_model/show/{id}',[VehicleModelController::class, 'show'])->name('veichle_model.show');
        Route::delete('veichle_model/delete/{id}',[VehicleModelController::class, 'destroy'])->name('veichle_model.destroy');

        //veichle Color routes
        Route::get('veichle_color', [VehicleColorController::class, 'index'])->name('veichle_color.index');
        Route::get('veichle_color/create',[VehicleColorController::class, 'create'])->name('veichle_color.create');
        Route::post('veichle_color/create',[VehicleColorController::class, 'store'])->name('veichle_color.store');
        Route::get('veichle_color/edit/{id}',[VehicleColorController::class, 'create'])->name('veichle_color.edit');
        Route::get('veichle_color/show/{id}',[VehicleColorController::class, 'show'])->name('veichle_color.show');
        Route::delete('veichle_color/delete/{id}',[VehicleColorController::class, 'destroy'])->name('veichle_color.destroy');

        //order routes
        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::get('order/show/{id}',[OrderController::class, 'show'])->name('order.show');
        Route::get('order/edit/{id}',[OrderController::class, 'edit'])->name('order.edit');
        Route::post('order/update/{id}',[OrderController::class, 'update'])->name('order.update');

        //Setting routes
        Route::get('complaints',[SettingController::class, 'get_complaints'])->name('complaints.index');
        Route::get('complaints/{id}',[SettingController::class, 'show_complaints'])->name('complaints.show');
        Route::delete('complaints/delete/{id}',[SettingController::class, 'destroy_complaints'])->name('complaints.destroy');

        Route::get('about/{id}',[SettingController::class, 'index_about'])->name('about.index');
        Route::post('about/update/{id}',[SettingController::class, 'update_about'])->name('about.update');
        Route::get('terms/{id}',[SettingController::class, 'index_terms'])->name('terms.index');
        Route::post('terms/update/{id}',[SettingController::class, 'update_terms'])->name('terms.update');

        Route::get('privacy/{id}',[SettingController::class, 'index_privacy'])->name('privacy.index');
        Route::post('privacy/update/{id}',[SettingController::class, 'update_privacy'])->name('privacy.update');

        Route::get('setting/{id}',[SettingController::class, 'index'])->name('setting.index');
        Route::post('setting/update/{id}',[SettingController::class, 'update'])->name('setting.update');

        Route::get('push-notification', [NotificationController::class, 'index'])->name('show.notification');
        Route::post('/send-notification', [NotificationController::class, 'sendOfferNotification'])->name('send.notification');

        Route::get('push-driver-notification', [NotificationController::class, 'driver_notification'])->name('showdriver.notification');
        Route::post('/send-driver-notification', [NotificationController::class, 'driverSendOfferNotification'])->name('senddriver.notification');

    });
});
