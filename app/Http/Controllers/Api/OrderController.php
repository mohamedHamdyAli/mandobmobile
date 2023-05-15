<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DriverInfoResource;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Order_request;
use App\Models\Veichle;
use App\Models\CancellOrder;
use App\Models\Wallet;
use App\Models\DriverOrderStatus;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderDriverResource;
use App\Http\Resources\OrderstatusResource;
use App\Http\Resources\OrderStatusadResource;
use App\Http\Resources\CancellationResource;
use App\Http\Resources\OrderSearchResource;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\OrderRequest;
use App\Helper\CustomHelper;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    public function index() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") ;
            return $this->sendResponse(OrderResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }


        // return OrderResource::collection($order);
    }
    public function store(OrderRequest $request) {

        if(auth()->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendError($message, ['error'=>$message]);
        }

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['status'] = 'pending';
        $data['zone_id'] = auth()->user()->zone_id;




        $data_veichke = Veichle::where('id','=', $request->veichle_type_id)->first();
        $order_req = Order::updateOrCreate(['id' => $request->id], $data);

        
        if (is_array($request->orders)) {
            foreach($request->orders as $order) {
                $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                    $order_req->lat_from, $order_req->long_from, $order['lat_to'],
                    $order['long_to'], 'kilometers');

                if ($kilomaters <= $data_veichke->max_num_km) {
                    $total_price = $kilomaters * $data_veichke->amount;
                    } else {
                    $extra_km = $kilomaters - $data_veichke->max_num_km;
                    $extra_price = $extra_km * $data_veichke->extra_price;
                    $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
                }
                Order_request::create([
                    'address_to' => $order['address_to'],
                    'order_id' => $order_req->id,
                    'lat_to' => $order['lat_to'],
                    'long_to' => $order['long_to'],
                    'order_name' => $order['order_name'],
                    'client_name' => $order['client_name'],
                    'phone' => $order['phone'],
                    'price' => $total_price,
                    'block' => $order['block'],
                    'buliding_num' => $order['buliding_num'],
                    'road' => $order['road'],
                    'flat_office' => $order['flat_office'],
                ]);

            }
        } else {
            foreach($request->orders as $order) {
                $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                    $order_req->lat_from, $order_req->long_from, $order['lat_to'],
                    $order['long_to'], 'kilometers');

                if ($kilomaters <= $data_veichke->max_num_km) {
                    $total_price = $kilomaters * $data_veichke->amount;
                    } else {
                    $extra_km = $kilomaters - $data_veichke->max_num_km;
                    $extra_price = $extra_km * $data_veichke->extra_price;
                    $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
                }
                $key_amount = collect($request->orders)->sum('price');
                Order_request::create([
                    'address_to' => $order['address_to'],
                    'order_id' => $order_req->id,
                    'lat_to' => $order['lat_to'],
                    'long_to' => $order['long_to'],
                    'order_name' => $order['order_name'],
                    'client_name' => $order['client_name'],
                    'phone' => $order['phone'],
                    'price' => $total_price,
                    'block' => $order['block'],
                    'buliding_num' => $order['buliding_num'],
                    'road' => $order['road'],
                    'flat_office' => $order['flat_office'],
                ]);
            }
        }
        $cost = array();
        foreach($request->orders as $val){
            $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                $request->lat_from, $request->long_from, $val['lat_to'],
                $val['long_to'], 'kilometers');

            if ($kilomaters <= $data_veichke->max_num_km) {
                $total_price = $kilomaters * $data_veichke->amount;
                } else {
                $extra_km = $kilomaters - $data_veichke->max_num_km;
                $extra_price = $extra_km * $data_veichke->extra_price;
                $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
            }            
            $cost[] = array(
                "pricee" => $total_price,
                "kilomaters" => $kilomaters
            );
        }
        $key_amount = collect($cost)->sum('pricee');
        $order_req = Order::find($order_req->id);
        $order_req->total_cost = $key_amount;
        $order_req->save();
        if(count($request->orders) > 1) {
            Wallet::create([
                'wallet' => (new CustomHelper)->setting_data('wallet_user'),
                'user_id' => auth()->user()->id,
                'date' => date("Y/m/d"),
                'time' => now(),
            ]);
        }

        if(isset($order_req->id)) {
            DriverOrderStatus::create([
                'order_id' => $order_req->id,
                'user_id' => auth()->user()->id,
                'driver_id' => null,
                'status' => 'pending',
            ]);

            $drivers = Driver::select('id')->whereRaw("FIND_IN_SET(?, zone_id) > 0", [$data['zone_id']])->pluck('id')->toArray();
            $body = 'New Order uploaded in your zone' ;
            $body_ar = 'طلب جديد تم تحميله في منطقتك' ;
            (new CustomHelper)->driversendnotficationmultiple($drivers, $body,$body_ar,$request->id);
    
        }



        $message = __("auth.Order_Created") ;
        return $this->sendResponse(new OrderResource($order_req), $message);
    }
    public function show($id) {
        $user = auth()->user()->id;
        // $model = Order::findOrFail($id);
        $order = Order::where('user_id','=',$user)->where('id',$id)->first();
        // $order = Order::where('user_id','=',$user)->where('status','=','accept')->where('id',$id)->first();
        $data = DB::table('drivers_accept')->select('*')
        ->where('order_id',$order->id)->first();
        $driver_data = Driver::where('id',$data->driver_id)->first();
        if(is_null($data->driver_id)) {
            $message = __("auth.Order_details") ;
            return $this->sendResponse(new OrderResource($order), $message);
        } else {
            $message = __("auth.Order_details") ;
            $response = [
                'success' => true,
                'data'    => new OrderResource($order),
                'driver' => new DriverInfoResource($driver_data),
                'message' => $message,
            ];
            return response()->json($response, 200);
            // return $this->sendResponse(new OrderResource($order), $message);
        }
    }

    public function update(Request $request, $id) {
        if(auth()->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendError($message, ['error'=>$message]);
        }
        $data = $request->all();
        $order_data = Order::findOrFail($id);
        $data_veichke = Veichle::where('id','=', $request->veichle_type_id)->first();
        Order_request::where('order_id', '=', $id)->delete();
        if (is_array($request->orders)) {
            foreach($request->orders as $order) {
                $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                    $order_data->lat_from, $order_data->long_from, $order['lat_to'],
                    $order['long_to'], 'kilometers');

                if ($kilomaters <= $data_veichke->max_num_km) {
                    $total_price = $kilomaters * $data_veichke->amount;
                    } else {
                    $extra_km = $kilomaters - $data_veichke->max_num_km;
                    $extra_price = $extra_km * $data_veichke->extra_price;
                    $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
                }
                Order_request::create([
                    'address_to' => $order['address_to'],
                    'order_id' => $id,
                    'lat_to' => $order['lat_to'],
                    'long_to' => $order['long_to'],
                    'order_name' => $order['order_name'],
                    'client_name' => $order['client_name'],
                    'phone' => $order['phone'],
                    'price' => $total_price,
                    'block' => $order['block'],
                    'buliding_num' => $order['buliding_num'],
                    'road' => $order['road'],
                    'flat_office' => $order['flat_office'],
                ]);
            }
        } else {
            foreach($request->orders as $order) {
                $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                    $order_data->lat_from, $order_data->long_from, $order['lat_to'],
                    $order['long_to'], 'kilometers');

                if ($kilomaters <= $data_veichke->max_num_km) {
                    $total_price = $kilomaters * $data_veichke->amount;
                    } else {
                    $extra_km = $kilomaters - $data_veichke->max_num_km;
                    $extra_price = $extra_km * $data_veichke->extra_price;
                    $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
                }
                Order_request::create([
                    'address_to' => $order['address_to'],
                    'order_id' => $id,
                    'lat_to' => $order['lat_to'],
                    'long_to' => $order['long_to'],
                    'order_name' => $order['order_name'],
                    'client_name' => $order['client_name'],
                    'phone' => $order['phone'],
                    'price' => $total_price,
                    'block' => $order['block'],
                    'buliding_num' => $order['buliding_num'],
                    'road' => $order['road'],
                    'flat_office' => $order['flat_office'],
                ]);
            }
        }
        $cost = array();
        foreach($request->orders as $val){
            $kilomaters = (new CustomHelper)->getDistanceBetweenPointsNew(
                $request->lat_from, $request->long_from, $val['lat_to'],
                $val['long_to'], 'kilometers');

            if ($kilomaters <= $data_veichke->max_num_km) {
                $total_price = $kilomaters * $data_veichke->amount;
                } else {
                $extra_km = $kilomaters - $data_veichke->max_num_km;
                $extra_price = $extra_km * $data_veichke->extra_price;
                $total_price = $data_veichke->max_num_km * $data_veichke->amount + $extra_price;
            }            
            $cost[] = array(
                "pricee" => $total_price,
                "kilomaters" => $kilomaters
            );
        }
        // dd($cost);
        $key_amount = collect($cost)->sum('pricee');
        $data['total_cost'] = $key_amount;
        $order_data->fill($data)->update();
        $message = __("auth.Order_Update") ;
        return $this->sendResponse(new OrderResource($order_data), $message);
    }
    public function destroy($id) {
        if(auth()->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendError($message, ['error'=>$message]);
        }

        $order = Order::findOrFail($id);
        if($order){
            $order->delete();
            Order_request::where('order_id', '=', $id)->delete();
            $message = __("auth.Order_Deleted_Successfully") ;
            return $this->sendResponse('', $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_order(Request $request) {
        $order_status = $request->get('status');
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=',$order_status)->orderBy('id', 'desc')->paginate(10);

        if($order){
            $message = __("auth.All_Orders") . $order_status;
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }


    }
    public function get_pending_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','pending')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' pending';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_upcoming_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','upcoming')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' upcoming';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_delivered_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','delivered')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' delivered';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_accept_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','accept')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' delivered';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_ongoing_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','ongoing')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' delivered';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_cancel_order() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where('status','=','cancel')->orderBy('id', 'desc')->paginate(10);
        if($order){
            $message = __("auth.All_Orders") . ' cancel';
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function get_order_count() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->paginate(1);
        if($order){
            $message = __("auth.All_Orders");
            return $this->sendResponse(OrderstatusResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
    public function cancel_order(Request $request, $id) {
        if(auth()->user()->status == 0) {
            $message = __("auth.Your_account_is_inactive_Please_contact_system_administrator") ;
            return $this->sendError($message, ['error'=>$message]);
        }
        $order = Order::find($id);
        $data = DriverOrderStatus::where('order_id',$id)->first();
        $driver_id = $data->driver_id;
        if($order) {
            $order->status = 'cancel';
            $data->status = 'cancel';
            $order->cancell_details = $request->get('cancell_details');
            $order->save();
            $data->save();
            $body = 'Your order has been canceled Order number'.' '.$id ;
            $body_ar = 'تم رفض الطلب الخاص بك رقم'.' '.$id ;
            (new CustomHelper)->driverSendOrderNotification($driver_id, $body, $body_ar,$id);
            $message = __("auth.Order_Canceled");
            return $this->sendResponse([], $message);
        } else {
            $message = __("auth.Something_Error") ;
            return $this->sendError($message, '');
        }

    }
    public function driver_accept(Request $request, $id) {
        $order = Order::find($id);
        $driver_id = $request->get('driver_id');
        if($order) {
            $order->status = 'accept';
            $order->driver_id = $driver_id;
            $order->save();

            $message = __("auth.Order_Accepted");
            return $this->sendResponse([], $message);
        } else {
            $message = __("auth.Something_Error") ;
            return $this->sendError($message, '');
        }
    }
    public function get_driver_order_details($id) {
        // $model = Order::find($id);
        $user = auth()->user()->id;
        $order = Order::select('id', 'address_from', 'user_id', 'status')
        ->where('user_id','=',$user)->where('status','=','accept')->where('id',$id)->first();
        $data = DB::table('drivers_accept')->select('*')
        ->where('order_id',$order->id)->first();
        $driver_data = Driver::where('id',$data->driver_id)->first();
        if(is_null($order)) {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        } else {
            $message = __("auth.driver_details") ;
            $response = [
                'success' => true,
                'data'    => new OrderDriverResource($order),
                'driver' => new DriverInfoResource($driver_data),
                'message' => $message,
            ];
            return response()->json($response, 200);
            // return $this->sendResponse(new OrderDriverResource($order), $message);
        }
    }
    public function search_by_id(Request $request) {
        $user = auth()->user()->id;
        $order_id = $request->get('id');
        $order = Order::where('user_id','=',$user)->where('id','=',$order_id)->first();
        if(is_null($order)) {
            $message = __("auth.Id_Not_Found") ;
            return $this->sendError($message, '');
        } else {
            $message = __("auth.Order_details") ;
            return $this->sendResponse(new OrderSearchResource($order), $message);
        }
    }
    public function total_amount(Request $request) {
        $lat_from = $request->get('lat_from');
        $lon_from = $request->get('long_from');
        $veichle = $request->get('veichle_type_id');
        $unit = 'kilometers';
        $data = Veichle::select('amount')->where('id','=', $veichle)->first();
        $cost = array();
        foreach($request->order_details as $val){
            if($data == null) {
                $message = __("auth.Something_Error") ;
            } else {
                $cost[] = array(
                    "price" => (new CustomHelper)->getDistanceBetweenPointsNew($lat_from,$lon_from,$val['lat_to'],$val['long_to'],$unit) * $data->amount
                );
            }
        }
        $key_amount = collect($cost)->sum('price');
        if(empty($key_amount)) {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        } else {
            $message = __("auth.Total_Amount") ;
            if ($request->header("Language") == 'en') {
                return $this->sendResponse($key_amount . ' '. (new CustomHelper)->setting_data('currency'), $message);
            } else {
                return $this->sendResponse($key_amount . ' دينار ', $message);

            }
        }
    }
    public function order_home() {
        $user = auth()->user()->id;
        $order = Order::where('user_id','=',$user)->where(function($q) {
            $q->where('status', 'pending');
        })->orderBy('id', 'desc')->get();
        if($order == null || auth()->user()->status == 0) {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            $response = [
                'success' => true,
                'data'    => '',
                'message' => $message,
            ];
            return response()->json($response, 200);
            // return $this->sendError($message, '');
        }else  {
            $message = __("auth.All_Orders");
            return $this->sendResponse(OrderStatusadResource::collection($order), $message);
       }
    }
    public function get_cancellation_details() {
        $order = CancellOrder::all();
        if($order){
            $message = __("auth.All_Cancellation");
            return $this->sendResponse(CancellationResource::collection($order), $message);
        } else {
            $message = __("auth.These_credentials_do_not_match_our_records") ;
            return $this->sendError($message, '');
        }
    }
}
