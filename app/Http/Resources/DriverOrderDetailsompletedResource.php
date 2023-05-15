<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Order_request;
use App\Helper\CustomHelper;

class DriverOrderDetailsompletedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders = Order_request::select('id','address_to','order_name','phone','client_name','block','buliding_num','road','flat_office')->where('order_id',$this->id)->get();

        return [
            'id' => $this->id,
            'address_from' => $this->address_from,
            'total_cost' => $this->total_cost,
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',
            'order_date' => $this->order_date,
            'order_time' => $this->order_time,
            'status' => $this->status,
            'veichle_type_id ' => $this->veichle_type_id ,
            'veichle_type_name' =>$request->header("Language") == 'ar' ?optional($this->veichle_type)->name_ar : optional($this->veichle_type)->name_en,
            'order' => $orders

        ];
    }
}
