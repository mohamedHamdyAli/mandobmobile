<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order;

class OrderstatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order_pending = Order::where('user_id','=',$this->user_id)->where('status','=','pending')->count();
        $order_upcoming = Order::where('user_id','=',$this->user_id)->where('status','=','upcoming')->count();
        $order_delivered = Order::where('user_id','=',$this->user_id)->where('status','=','delivered')->count();
        $order_accept = Order::where('user_id','=',$this->user_id)->where('status','=','accept')->count();


        return [
            'order_pending' => $order_pending,
            'order_upcoming' => $order_upcoming,
            'order_delivered' => $order_delivered,
            'order_accept' => $order_accept,

        ];
    }
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

}
