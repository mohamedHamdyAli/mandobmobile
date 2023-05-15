<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order_request;
use App\Models\Order;
use App\Helper\CustomHelper;

class DriverOrderDeliveredResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders_req = Order_request::select('id','address_to')->where('order_id',$this->order_id)->get();
        // $orders = Order::select('id','address_from','order_date','order_time','total_cost')->where('id',$this->order_id)->get();
        return [
            'id' => $this->id,
            'order_date' =>date('F j, Y',strtotime(optional($this->order)->order_date)),
            'order_time' =>date('g:i a',strtotime(optional($this->order)->order_time)),
            'total_cost' =>optional($this->order)->total_cost,
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',
            'address_from' =>optional($this->order)->address_from,
            'order_id' =>optional($this->order)->id,
            'orders_req' => $orders_req

        ];
    }
}
