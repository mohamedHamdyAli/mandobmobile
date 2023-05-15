<?php
namespace App\Helper;
use App\Models\Driver;
use App\Models\Notifications;
use App\Models\Setting;
use App\Models\About;
use App\Models\TermsConditions;
use App\Models\PrivacyPolicy;
use App\Models\User;

class CustomHelper
{
    public function setting_data($data) {
        $setting = Setting::first();
        return $setting->$data;
    }
    public function about_data($data) {
        $about = About::first();
        return $about->$data;
    }
    public function terms_data($data) {
        $terms = TermsConditions::first();
        return $terms->$data;
    }
    public function privacy_data($data) {
        $privacy = PrivacyPolicy::first();
        return $privacy->$data;
    }
    public function setting_image() {
        $setting = Setting::first();
        return $setting;
    }
    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit ) {
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;
        switch($unit) {
          case 'miles':
            break;
          case 'kilometers' :
            $distance = $distance * 1.609344;
        }
        return (round($distance,2));
    }

    public function sendOrderNotification($user_id,$body,$body_ar )
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $firebaseToken = User::Where('id', $user_id)->whereNotNull('device_key')->pluck('device_key')->first();

        $SERVER_API_KEY = env('FCM_API_KEY');

        $data = [
            "to" => $firebaseToken,
            "notification" => [
                "title" => 'Status has been changed',
                "title_ar" => 'تم تغيير الحالة',
                "body" => $body,
                "body_ar" => $body_ar,
            ]
        ];

        Notifications::create([
            'user_id' => $user_id,
            "title" => 'Status has been changed',
            "title_ar" => 'تم تغيير الحالة',
            "body" => $body,
            "body_ar" => $body_ar,
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
        return $result;   
    }

    public function driverSendOrderNotification($driver_id, $body,$body_ar, $order_id)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        
        $firebaseToken = Driver::Where('id', $driver_id)->whereNotNull('device_key')->pluck('device_key')->first();
        
        $SERVER_API_KEY = env('FCM_API_KEY_DRIVER');

        $data = [
            "to" => $firebaseToken,
            "notification" => [
                "title" => 'Status has been changed',
                "title_ar" => 'تم تغيير الحالة',
                "body" => $body,
                "body_ar" => $body_ar,
            ]
        ];

        Notifications::create([
            'driver_id' => $driver_id,
            "title" => 'Status has been changed',
            "title_ar" => 'تم تغيير الحالة',
            "body" => $body,
            "body_ar" => $body_ar,
            "order_id" => $order_id,
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
        
        return $result;   
        
    }

    public function driversendnotficationmultiple($ids, $body, $body_ar,$order_id) {
        $users = Driver::whereIn('id', $ids)->get()->toArray();
        $SERVER_API_KEY = env('FCM_API_KEY_DRIVER');
        $data = [
            "title" => 'A new order has been created',
            "title_ar" => 'تم إنشاء طلب جديد',
            "body" => $body,
            "body_ar" => $body_ar,
            "order_id" => $order_id
        ];
    
        foreach ($users as $user) {
            $token = $user['device_key'];
    
            $url = 'https://fcm.googleapis.com/fcm/send';
    
            $notificationData = [
                "to" => $token,
                "notification" => [
                    "data" => $data
                ]
            ];
    
            Notifications::create([
                'driver_id' => $user['id'],
                "title" => 'Status has been changed',
                "title_ar" => 'تم تغيير الحالة',
                "body" => $body,
                "body_ar" => $body_ar,
                "order_id" => $order_id,
            ]);
    
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json'
            ];
    
            $ch = curl_init();
    
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
    
            $result = curl_exec($ch);
    
            curl_close($ch);
        }
        // dd($result);
        return $result; 
    }
    
}
