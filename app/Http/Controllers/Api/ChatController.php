<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\DriverChatResource;
use App\Http\Resources\UserChatResource;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\DriverOrderStatus;

class ChatController extends BaseController
{
    public function user_message(Request $request) {
        $user = auth()->user()->id;
        $data = $request->all();
        $data['user_id'] = $user;
        $data['date'] = date("Y/m/d");
        $data['time'] = now();
        $data['flag'] = true;
        $data['read'] = "false";
        Chat::Create($data);
        $message = __("auth.Message send") ;
        return $this->sendResponse('', $message);
    }

    public function driver_message(Request $request) {
        $driver = auth()->guard('driver')->user()->id;
        $data = $request->all();
        $data['driver_id'] = $driver;
        $data['date'] = date("Y/m/d");
        $data['time'] = now();
        $data['flag'] = false;
        $data['read'] = "false";
        Chat::Create($data);
        $message = __("auth.Message send") ;
        return $this->sendResponse('', $message);
    }
    public function get_user_message(Request $request) {
        $user = auth()->user()->id;
        $driver_id = $request->get('driver_id');
        $order_id = $request->get('order_id');
        $chats = Chat::where('user_id','=',$user)->where('driver_id','=',$driver_id)
        ->where('order_id',$order_id)->get();
        if($chats){
            $message = __("auth.messages") ;
            return $this->sendResponse(ChatResource::collection($chats), $message);
        } else {
            $message = __("auth.Something error") ;
            return $this->sendError($message, '');
        }
    }
    public function get_driver_message(Request $request) {
        $driver = auth()->guard('driver')->user()->id;
        $user_id = $request->get('user_id');
        $order_id = $request->get('order_id');
        $chats = Chat::where('driver_id','=',$driver)->where('user_id','=',$user_id)->where('order_id',$order_id)->get();
        if($chats){
            $message = __("auth.messages") ;
            return $this->sendResponse(ChatResource::collection($chats), $message);
        } else {
            $message = __("auth.Something error") ;
            return $this->sendError($message, '');
        }
    }

    public function get_driver_chat() {
        $user = auth()->user()->id;
        $user_order =  DriverOrderStatus::where('user_id',$user)->where('status','!=','pending')
        ->where('status','!=','cancel')->orderBy('id', 'desc')->get();

        if($user_order != null){
            $message = __("auth.All_Drivers") ;
            return $this->sendResponse(UserChatResource::collection($user_order), $message);
        } 
    }
    public function get_user_chat() {
        $driver = auth()->guard('driver')->user()->id;
        $driver_order =  DriverOrderStatus::where('driver_id',$driver)->where('status','!=','pending')->where('status','!=','cancel')->orderBy('id', 'desc')->get();
        if($driver_order != null){
            $message = __("auth.All_Users") ;
            return $this->sendResponse(DriverChatResource::collection($driver_order), $message);
        } 
    }

    public function update_user_read(Request $request) {
        $user = auth()->user()->id;
        $driver_id = $request->post('driver_id');
        $order_id = $request->post('order_id');  
        $chats = Chat::where('user_id', '=', $user)
            ->where('driver_id', '=', $driver_id)
            ->where('order_id', $order_id)
            ->where('flag', 1)
            ->update(['read' => 'true']);
        $message = __("auth.messages") ;
        return $this->sendResponse('',$message);
    }

    public function update_driver_read(Request $request) {
        $driver = auth()->guard('driver')->user()->id;
        $user_id = $request->post('user_id');
        $order_id = $request->post('order_id');  
        $chats = Chat::where('driver_id', '=', $driver)
            ->where('user_id', '=', $user_id)
            ->where('order_id', $order_id)
            ->where('flag', 0)
            ->update(['read' => 'true']);
        $message = __("auth.messages") ;
        return $this->sendResponse('',$message);
    }

}
