<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order_request;
use App\Helper\CustomHelper;

class OrderSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders = Order_request::select('id','address_to','order_name')->where('order_id',$this->id)->get();

        return [
            'id' => $this->id,
            'address_from' => $this->address_from,
            'total_cost' => $this->total_cost,
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',
            'status' => $this->status,
            'order' => $orders

        ];
    }
}
