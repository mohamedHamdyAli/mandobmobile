<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    // public function register(UserRequest $request)
    // {
    //     $input = $request->all();

    //     $password = $input['password'];
    //     $input['username'] = $input['first_name']." ".$input['last_name'];
    //     $input['user_type'] = isset($input['user_type']) ? $input['user_type'] : 'user';
    //     $input['password'] = Hash::make($password);
    //     $input['status'] = isset($input['status']) ? $input['status']: 0;

    //     $user = User::create($input);
    //     $input['api_token'] = $user->createToken('auth_token')->plainTextToken;

    //     unset($input['password']);
    //     $message = "User Created";
    //     $user->api_token = $user->createToken('auth_token')->plainTextToken;
    //     $response = [
    //         'message' => $message,
    //         'data' => $user
    //     ];
    //     // return comman_custom_response($response);
    //     return response()->json($response, 200);
    // }
    // public function login()
    // {
    //     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){

    //         $user = Auth::user();
    //         if(request('loginfrom') === 'user-app'){
    //             if($user->user_type != 'user'){
    //                 $message = "You can not login from here only user can login";
    //                 return response()->json($message, 400);
    //             }
    //         }
    //         $user->save();

    //         if ($user['status'] == 0) {
    //             $message = "Your account is inactive. Please contact system administrator";
    //             return response()->json($message, 400);
    //         }

    //         // $success = "User Login successfully";

    //         return response()->json([ 'data' => $user ], 200 );
    //     } else{
    //         $message = "These credentials do not match our records";

    //         return response()->json($message, 400);
    //     }
    // }

    public function login()
    {
        return view('auth.otpLogin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generate(Request $request)
    {
        /* Validate Data */
        $request->validate([
            'phone' => 'required|exists:users,phone'
        ]);

        /* Generate An OTP */
        $userOtp = $this->generateOtp($request->phone);
        $userOtp->sendSMS($request->phone);

        return redirect()->route('otp.verification', ['user_id' => $userOtp->user_id])
                         ->with('success',  "OTP has been sent on Your Mobile Number.");
        // return response()->json([ 'user_id' => $userOtp->user_id ], 200 );
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateOtp($phone)
    {
        $user = User::where('phone', $phone)->first();

        /* User Does not Have Any Existing OTP */
        $userOtp = UserOtp::where('user_id', $user->id)->latest()->first();

        $now = now();

        if($userOtp && $now->isBefore($userOtp->expire_at)){
            return $userOtp;
        }

        /* Create a New OTP */
        return UserOtp::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => $now->addMinutes(10)
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function verification($user_id)
    {
        return view('auth.otpVerification')->with([
            'user_id' => $user_id
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function loginWithOtp(Request $request)
    {
        /* Validation */
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        /* Validation Logic */
        $userOtp   = UserOtp::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = now();
        if (!$userOtp) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
            // return response()->json('Your OTP is not correct', 400);
        }else if($userOtp && $now->isAfter($userOtp->expire_at)){
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
            // return response()->json('Your OTP has been expired', 400);
        }

        $user = User::whereId($request->user_id)->first();

        if($user){

            $userOtp->update([
                'expire_at' => now()
            ]);

            Auth::login($user);

            // return redirect('/home');
            return response()->json([ 'user_id' => $user ], 200 );
        }

        return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
        // $message = "Your Otp is not correct";
        // return response()->json($message, 400);
    }

}
