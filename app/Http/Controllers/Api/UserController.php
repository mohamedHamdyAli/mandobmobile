<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\OtpRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Wallet;
use App\Http\Resources\UserResource;
use App\Http\Resources\OtpResource;
use App\Http\Resources\WalletResource;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Helper\CustomHelper;
use App\Models\DriverRate;
use App\Services\FCMService;

class UserController extends BaseController
{
    public function register(UserRequest $request)
    {

        $input = $request->all();

        $input['username'] = $input['username'];
        $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';
        $input['zone_id'] = isset($input['zone_id']) ? $input['zone_id'] : '';
        $input['status'] = isset($input['status']) ? $input['status']: 1;
        $input['user_otp'] = 1111;
        // $input['user_otp'] = rand(123456, 999999);
        $input['expire_at'] = now()->addMinutes(10);
        $user = User::create($input);
        $message = __("auth.User_Created") ;
        if($request->hasFile('profile_image') && $request->file('profile_image')->isValid()){
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        return $this->sendResponse('', $message);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('phone', $request->get('phone'))->first();
        if($user){
            $user->save();
            $success = $user;
            if ($user['status'] == 0) {
                $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
                return $this->sendError('Unauthorised.', ['error'=>$message]);
            }
            $success = User::find($user['id']);
            $success->user_otp = 1111;
            $success->expire_at = now()->addMinutes(10);
            $success->save();

            return $this->sendResponse('', __("auth.Please_Check_Your_Phone"));
        } else{
            $message = __("auth.This_Phone_Not_Found_In_Our_system") ;
            return $this->sendError($message, '');

        }
    }

    public function loginWithOtp(OtpRequest $request)
    {
        $user = User::where('phone', $request->get('phone'))->where('user_otp', $request->get('user_otp'))->first();
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

    public function show()
    {
        $user = auth()->guard('api')->user();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        }
        return $this->sendResponse(new UserResource($user), __("auth.User_Data"));

    }

    public function update_profile(ProfileRequest $request) {
        $user = auth()->user();
        if($request->has('id') && !empty($request->id)){
            $user = User::where('id',$request->id)->first();
        }
        if($user == null){
            $message = __("auth.User_Not_Found") ;

            return $this->sendError($message);
        }
        $user->fill($request->all())->update();

        if(isset($request->profile_image) && $request->profile_image != null ) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        $message = __("auth.Data_Has_Been_Updated") ;

        return $this->sendResponse(new UserResource($user), $message);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendResponse('', __("auth.Successfully_logged_out"));

    }

    public function get_wallet_user(Request $request) {
        $user = auth()->user()->id;
        $wallet = Wallet::where('user_id',$user)->get();
        if($wallet) {
            $message = __("auth.wallet") ;
            $response = [
                'success' => true,
                'data'    => WalletResource::collection($wallet),
                'total'    => $request->header("Language") == 'en' ? collect($wallet)->sum('wallet') . ' ' .  (new CustomHelper)->setting_data('currency') : collect($wallet)->sum('wallet')  .' دينار ',
                'message' => $message,
            ];
            return response()->json($response, 200);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function driver_rate(Request $request) {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['user_type'] = 'driver';
        DriverRate::create($data);
        $message = __("auth.Data_Has_Been_Added") ;
        return $this->sendResponse('', $message);
    }

    public function update_device_token(Request $request) {
        $data = $request->all();
        $user = User::where('id',auth()->user()->id)->first();
        if(empty($user))
        {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message);
        } else {
            $user->device_key = $data['device_key'];
            $user->save();
            return $this->sendResponse('', __("auth.update_User_Data"));
    
        }
    }
}
