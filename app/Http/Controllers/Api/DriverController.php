<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\DriverInfoResource;
use App\Models\DriverCancel;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests\DriverRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Driver;
use App\Models\VehicleBrand;
use App\Models\Order;
use App\Models\Order_request;
use App\Models\DriverOrderStatus;
use App\Models\DriverRate;
use App\Models\DriverWallet;
use App\Http\Resources\UserResource;
use App\Http\Resources\DriverServiceLocationResource;
use App\Http\Resources\DriverVechileModelResource;
use App\Http\Resources\DriverOrderAcceptResource;
use App\Http\Resources\OtpResource;
use App\Http\Resources\DriverResource;
use App\Http\Resources\DriverOrderDeliveredResource;
use App\Http\Resources\DriverVechileOnfoResource;
use App\Http\Resources\DriverVechileBrandResource;
use App\Http\Resources\DriverVechileColorResource;
use App\Http\Resources\DriverOrderResource;
use App\Http\Resources\OrderDriverResource;
use App\Http\Resources\DriverOrderDetailsompletedResource;
use App\Http\Resources\WalletResource;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\VehicleModel;
use App\Models\VehicleColor;
use App\Helper\CustomHelper;
use App\Models\DriverAccept;
use Illuminate\Support\Facades\DB;

class DriverController extends BaseController
{
    public function driver_register(DriverRequest $request) {

        $input = $request->all();

        $input['username'] = $input['username'];
        $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'driver';
        // $input['zone_id'] = isset($input['zone_id']) ? implode(',', $input['zone_id']) : '';
        $input['status'] = isset($input['status']) ? $input['status']: 0;
        $input['user_otp'] = 1111;
        // $input['user_otp'] = rand(123456, 999999);
        $input['expire_at'] = now()->addMinutes(10);
        $user = Driver::create($input);
        $message = __("auth.Driver Created") ;
        if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        if($request->hasFile('driver_licnse') && $request->file('driver_licnse')->isValid()){
            $user->addMediaFromRequest('driver_licnse')->toMediaCollection('driver_licnse');
        }
        if($request->hasFile('registration_sicker') && $request->file('registration_sicker')->isValid()){
            $user->addMediaFromRequest('registration_sicker')->toMediaCollection('registration_sicker');
        }
        if($request->hasFile('vehicle_insurance') && $request->file('vehicle_insurance')->isValid()){
            $user->addMediaFromRequest('vehicle_insurance')->toMediaCollection('vehicle_insurance');
        }

        return $this->sendResponse('', $message);
    }
    public function driver_login(LoginRequest $request) {
        $user = Driver::where('phone', $request->get('phone'))->first();
        if($user){
            $user->save();
            $success = $user;
            if ($user['status'] == 0) {
                $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
                return $this->sendError($message);
            }
            $success = Driver::find($user['id']);
            $success->user_otp = 1111;
            $success->expire_at = now()->addMinutes(10);
            $success->save();

            return $this->sendResponse('', __("auth.Please_Check_Your_Phone"));
        } else{
            $message = __("auth.This_Phone_Not_Found_In_Our_system") ;
            return $this->sendError($message, '');

        }
    }
    public function driver_loginWithOtp(OtpRequest $request) {
        $user = Driver::where('phone', $request->get('phone'))->where('user_otp', $request->get('user_otp'))->first();
        if($user && now()->isAfter($user->expire_at)) {
            $message = __("auth.Your_OTP_has_been_expired") ;
            return $this->sendError($message);
        } else if($user){
            return $this->sendResponse(new OtpResource($user), __("auth.success_Login"));
        } else {
            $message = __("auth.Your_OTP_is_not_correct") ;
            return $this->sendError($message);
        }
    }
    public function driver_show() {
        $user = auth()->guard('driver')->user();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(new DriverResource($user), __("auth.Driver_Data"));

    }
    public function driver_profile(ProfileRequest $request) {
        $user = auth()->guard('driver')->user();
        if($request->has('id') && !empty($request->id)){
            $user = Driver::where('id',$request->id)->first();
        }
        if($user == null){
            $message = __("auth.Driver_Not_Found") ;

            return $this->sendError($message);
        }
        $user->fill($request->all())->update();
        if(isset($request->profile_image) && $request->profile_image != null ) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        $message = __("auth.Data_Has_Been_Updated") ;

        return $this->sendResponse('', $message);
    }
    public function get_driver_service_location() {
        $user = auth()->guard('driver')->user();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(new DriverServiceLocationResource($user), __("auth.Driver_Data"));
    }
    public function update_driver_profile(ProfileRequest $request) {
        $user = auth()->guard('driver')->user();
        if($request->has('id') && !empty($request->id)){
            $user = Driver::where('id',$request->id)->first();
        }
        if($user == null){
            $message = __("auth.Driver_Not_Found") ;

            return $this->sendError($message);
        }
        $input = $request->all();
        // $input['zone_id'] = isset($input['zone_id']) ? implode(',', $input['zone_id']) ;
        $user->fill($input)->update();

        if(isset($request->profile_image) && $request->profile_image != null ) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        if(isset($request->driver_licnse) && $request->driver_licnse != null){
            $user->clearMediaCollection('driver_licnse');
            $user->addMediaFromRequest('driver_licnse')->toMediaCollection('driver_licnse');
        }
        if(isset($request->registration_sicker) && $request->registration_sicker != null){
            $user->clearMediaCollection('registration_sicker');
            $user->addMediaFromRequest('registration_sicker')->toMediaCollection('registration_sicker');
        }
        if(isset($request->vehicle_insurance) && $request->vehicle_insurance != null){
            $user->clearMediaCollection('vehicle_insurance');
            $user->addMediaFromRequest('vehicle_insurance')->toMediaCollection('vehicle_insurance');
        }
        $message = __("auth.Data_Has_Been_Updated") ;

        return $this->sendResponse('', $message);
    }
    public function get_vechile_informations() {
        $user = auth()->guard('driver')->user();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(new DriverVechileOnfoResource($user), __("auth.Driver_Data"));
    }
    public function get_vechile_brand() {
        $vechile_brand = VehicleBrand::orderBy('id', 'desc')->get();
        if(empty($vechile_brand))
        {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(DriverVechileBrandResource::collection($vechile_brand), __("auth.Driver_Data"));
    }
    public function get_vechile_color() {
        $vechile_color = VehicleColor::orderBy('id', 'desc')->get();
        if(empty($vechile_color))
        {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(DriverVechileColorResource::collection($vechile_color), __("auth.Driver_Data"));
    }
    public function get_vechile_model(Request $request) {
        $vechile_brand = $request->get('vechile_brand');
        $vechile_model = VehicleModel::where('vehicle_brand_id','=',$vechile_brand)->orderBy('id', 'desc')->get();
        if(empty($vechile_model))
        {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(DriverVechileModelResource::collection($vechile_model), __("auth.Driver_Data"));
    }
    public function get_order_zone() {

        if(auth()->guard('driver')->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendResponse('', $message);
        }

       
        

        $driver_id = auth()->guard('driver')->user()->id;
        $drivers = auth()->guard('driver')->user()->zone_id;
        $idsArr = explode(',',$drivers);
        $driver_stat = DB::table('driver_cancel')->where('driver_id',$driver_id)
        ->where('status','cancel')->pluck('order_id');

        // $driver_statArraa = explode(',',substr($driver_stat, 1, -1));
        
        $order = Order::whereIn('zone_id',$idsArr)->orderBy('orders.id', 'desc')
        ->join('drivers_accept', 'drivers_accept.order_id', '=', 'orders.id')
        ->where('orders.status','pending')
        ->whereIn('orders.id',$driver_stat, 'and', true)->get();

        $driver_wallet =  DriverWallet::where('driver_id',$driver_id)->get();
        $key_amount = collect($driver_wallet)->sum('wallet_cost');

        if(!empty($order)) {
            if($key_amount >= (new CustomHelper)->setting_data('wallet_driver')) {
                $message = __("auth.You cannot see any order until you pay the agreed amount") ;
                return $this->sendError($message);
            }
            return $this->sendResponse(DriverOrderResource::collection($order), __("auth.Driver_Task"));
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendError($message);
        }


    }

    public function get_driver_order_status(Request $request) {
        $id = $request->get('order_id');
        $order = Order::where('id', $id)->first();
        if($order) {
            $message = __("auth.Order_data") ;
            return $this->sendResponse(new OrderDriverResource($order), $message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendResponse('', $message);
        }
    }

    public function driver_order_accept(Request $request) {
            if(auth()->guard('driver')->user()->status == 0) {
                $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
                return $this->sendError($message, ['error'=>$message]);
            }
        $user = auth()->guard('driver')->user()->id;
        $id = $request->get('order_id');
        $data = DriverOrderStatus::where('order_id',$id)->first();
        $order = Order::where('id', $id)->first();
        $user_id = $order->user_id;

        $order_request = Order_request::where('order_id', $id)->get();
        $driver_percentage = (new CustomHelper)->setting_data('wallet_driver');
        $driver_wa = (new CustomHelper)->setting_data('wallet_driver_completed');
        $cost = array();
        foreach($order_request as $order_req){
            $cost[] = array(
                "price" => $order_req->price * $driver_wa / 100,
            );

        }
        $key_amount = collect($cost)->sum('price');

        $driver_wallet =  DriverWallet::where('driver_id',$user)->get();
        $key_amount_wallet = collect($driver_wallet)->sum('wallet_cost');
    
        $total = $key_amount_wallet  +  $key_amount;


        if($total > $driver_percentage) {
            $message = __("auth.You cannot accept this order because it will exceed the agreed amount") ;
            return $this->sendError($message);

        }

        if($data) {
            $data->driver_id = $user;
            $data->status = 'accept';
            $order->status = 'accept';
            $data->save();
            $order->save();
            $body = 'Your order has been accepted Order number'.' '.$order->id ;
            $body_ar = 'تم قبول الطلب الخاص بك رقم'.' '.$order->id ;
            (new CustomHelper)->sendOrderNotification($user_id, $body, $body_ar);
            $message = __("auth.Order_status_has_been_updated") ;
            return $this->sendResponse(new OrderDriverResource($order), $message);
        } else {
            $message = __("auth.Something_error") ;
            return $this->sendError($message);
        }


    }

    public function driver_order_cancel(Request $request) {
        if(auth()->guard('driver')->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendError('Unauthorised.', ['error'=>$message]);
        }
        $user = auth()->guard('driver')->user()->id;
        $id = $request->get('order_id');
        $data = DriverOrderStatus::where('order_id',$id)->first();
        $order = Order::where('id', $id)->first();
        $user_id = $order->user_id;
        if($data) {
            if( $data->status == 'accept') {
                $body = 'Your order has been canceled Order number'.' '.$order->id ;
                $body_ar = 'تم رفض الطلب الخاص بك رقم'.' '.$order->id ;
                (new CustomHelper)->sendOrderNotification($user_id, $body, $body_ar);
            }
            $data->status = 'pending';
            $order->status = 'pending';
            $data->save();
            $order->save();
            
            DriverCancel::create([
                'order_id'=>$id,
                'driver_id'=>$user,
                'status'=>'cancel',
                'user_id'=>$user_id,
            ]);

            $message = __("auth.Order_status_has_been_updated") ;
            return $this->sendResponse('', $message);
        } else {
            $message = __("auth.Something_error") ;
            return $this->sendError($message);
        }


    }

    public function driver_order_delivered(Request $request) {
        
        $user = auth()->guard('driver')->user()->id;
        $id = $request->get('order_id');
        $data = DriverOrderStatus::where('order_id',$id)->first();
        $order = Order::where('id', $id)->first();
        $user_id = $order->user_id;
        $order_request = Order_request::where('order_id', $id)->get();
        $driver_percentage = (new CustomHelper)->setting_data('wallet_driver_completed');
        $cost = array();
        foreach($order_request as $order_req){
            $cost[] = array(
                "price" => $order_req->price * $driver_percentage / 100,
                "price_only" => $order_req->price
            );

        }
        $key_amount = collect($cost)->sum('price');
        if($data) {
            $data->driver_id = $user;
            $data->status = 'delivered';
            $order->status = 'delivered';
            $data->save();
            $order->save();

            if($key_amount) {
                DriverWallet::create([
                    'wallet' => $order->total_cost,
                    'wallet_cost' => $key_amount,
                    'driver_id' => $user,
                    'date' => date("Y/m/d"),
                    'time' => now(),
                ]);
            }
            $body = 'Your order has been delivered Order number'.' '.$order->id ;
            $body_ar = 'تم توصيل الطلب الخاص بك رقم'.' '.$order->id ;
            (new CustomHelper)->sendOrderNotification($user_id, $body, $body_ar);
            $message = __("auth.Order_status_has_been_updated") ;
            return $this->sendResponse('', $message);
        } else {
            $message = __("auth.Something_error") ;
            return $this->sendError($message);
        }


    }

    public function driver_rate(Request $request) {
        $data = $request->all();
        $data['driver_id'] = auth()->guard('driver')->user()->id;
        $data['user_type'] = 'user';
        DriverRate::create($data);
        $message = __("auth.Data_Has_Been_Added") ;
        return $this->sendResponse('', $message);
    }

    public function get_wallet_driver(Request $request) {
        $driver = auth()->guard('driver')->user()->id;
        $wallet = DriverWallet::where('driver_id',$driver)->orderBy('id', 'desc')->get();
        if($wallet) {
            $message = __("auth.wallet") ;
            $response = [
                'success' => true,
                'data'    => WalletResource::collection($wallet),
                'total'    => $request->header("Language") == 'en' ? collect($wallet)->sum('wallet') . ' ' .  (new CustomHelper)->setting_data('currency') : collect($wallet)->sum('wallet')  .' دينار ',
                'driver_tax_value'    => $request->header("Language") == 'en' ?
                 collect($wallet)->sum('wallet_cost') . ' ' .  (new CustomHelper)->setting_data('currency')
                  : collect($wallet)->sum('wallet_cost')  .' دينار ',
                'message' => $message,
            ];
            return response()->json($response, 200);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }

    public function get_driver_order_accept() {
        $driver = auth()->guard('driver')->user()->id;
        $order = DriverOrderStatus::where('driver_id',$driver)->orderBy('id', 'desc')->where('status', 'accept')->get();
        if($order) {
            $message = __("auth.Order_data") ;
            return $this->sendResponse(DriverOrderAcceptResource::collection($order), $message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendResponse('', $message);
        }
    }
    public function get_driver_order_completed() {
        $driver = auth()->guard('driver')->user()->id;
        $order = DriverOrderStatus::where('driver_id',$driver)->orderBy('id', 'desc')->where('status', 'delivered')->get();
        if($order) {
            $message = __("auth.Order_data") ;
            return $this->sendResponse(DriverOrderDeliveredResource::collection($order), $message);
        } else {
            $message = __("auth.No_Data_found") ;
            return $this->sendResponse('', $message);
        }
    }

    public function get_driver_order_details_completed(Request $request) {
        $id = $request->get('order_id');
        $order = Order::where('id', $id)->first();
        $user_data = User::where('id',$order->user_id)->first();

        if($order) {
            $message = __("auth.Order_details") ;
            $response = [
                'success' => true,
                'data'    => new DriverOrderDetailsompletedResource($order),
                'user' => new UserResource($user_data),
                'message' => $message,
            ];
            return response()->json($response, 200);
        } else {
            $message = __("auth.Something_error") ;
            return $this->sendError($message);
        }
    }

    public function update_device_token(Request $request) {
        $data = $request->all();
        $user = Driver::where('id',auth()->guard('driver')->user()->id)->first();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        } else {
            $user->device_key = $data['device_key'];
            $user->save();
            return $this->sendResponse('', __("auth.update_Driver_Data"));
    
        }
    }
}
