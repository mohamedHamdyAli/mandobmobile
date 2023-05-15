<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $users = User::select('id', 'username')->get();
        return view('admin.pushNotification', compact('users'));
    }
    
    public function driver_notification()
    {
        $drivers = Driver::select('id', 'username')->get();
        return view('admin.driverPushNotification', compact('drivers'));
    }

     /**
     * Write code on Method
     *
     * @return response()
     */

    public function sendOfferNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $firebaseToken = User::Where('id', $request->user_id)->whereNotNull('device_key')->pluck('device_key')->first();
        
        $SERVER_API_KEY = env('FCM_API_KEY');

        $data = [
            "to" => $request->user_id == 'all' ? "/topics/all" : $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "title_ar" => $request->title_ar,
                "body" => $request->body,
                "body_ar" => $request->body_ar,
            ]
        ];

        $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'required',
            'body' => 'required',
            'body_ar' => 'required',
            'user_id' => 'required',
         ]);
          Notifications::create([
            'user_id' => $request->user_id,
            "title" => $request->title,
            "title_ar" => $request->title_ar,
            "body" => $request->body,
            "body_ar" => $request->body_ar,
        ]);
        
        // dd($data);
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);        
        return back()->with('success', 'Notification send successfully.');
    }

    public function driverSendOfferNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $firebaseToken = Driver::Where('id', $request->driver_id)->whereNotNull('device_key')->pluck('device_key')->first();
        
        $SERVER_API_KEY = env('FCM_API_KEY_DRIVER');

        $data = [
            "to" => $request->driver_id == 'all' ? "/topics/all" : $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "title_ar" => $request->title_ar,
                "body" => $request->body,
                "body_ar" => $request->body_ar,
            ]
        ];

        $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'required',
            'body' => 'required',
            'body_ar' => 'required',
            'driver_id' => 'required',
         ]);

        Notifications::create([
            'driver_id' => $request->driver_id,
            "title" => $request->title,
            "title_ar" => $request->title_ar,
            "body" => $request->body,
            "body_ar" => $request->body_ar,
        ]);
        
        // dd($data);
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        // dd($result);        
        return back()->with('success', 'Notification send successfully.');
    }
}
