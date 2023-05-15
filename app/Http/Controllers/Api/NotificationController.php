<?php

namespace App\Http\Controllers\Api;
use App\Http\Resources\AllNotificationResource;
use App\Http\Resources\NotificationResource;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;

class NotificationController extends BaseController
{
    public function notificationList(Request $request)
    {
        $user = auth()->user();

        $user->last_notification_seen = now();
        $user->save();

        $type = isset($request->type) ? $request->type : null;
        if($type == "markas_read"){
            if(count($user->unreadNotifications) > 0 ) {
                $user->unreadNotifications->markAsRead();
            }
        }

        $page = 1;
        $limit = 100;

        $notifications = $user->Notifications->sortByDesc('created_at')->forPage($page,$limit);

        $all_unread_count = isset($user->unreadNotifications) ? $user->unreadNotifications->count() : 0;
        $response = [
            'notification_data' => $notifications,
            'all_unread_count' => $all_unread_count,
        ];
        if($notifications){
            $message = __("auth.User_Notification") ;
            $response = [
                'success' => true,
                'data'    => NotificationResource::collection($notifications),
                'count'    => $all_unread_count,
                'message' => $message,
            ];
            return response()->json($response, 200);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }

    public function view_notification_user() {
        $user = auth()->user()->id;
        $notification = Notifications::whereIn('user_id',["$user",'all'])->orderBy('id', 'desc')->get();
        if($notification != null){
            $message = __("auth.All_notification");
            return $this->sendResponse(AllNotificationResource::collection($notification), $message);
        }
    }

    public function view_notification_driver() {
        $driver = auth()->guard('driver')->user()->id;
        $notification = Notifications::whereIn('driver_id',["$driver",'all'])->orderBy('id', 'desc')->get();
        if($notification != null){
            $message = __("auth.All_notification");
            return $this->sendResponse(AllNotificationResource::collection($notification), $message);
        }
    }
}
