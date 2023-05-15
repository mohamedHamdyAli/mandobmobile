<?php

namespace App\Http\Resources;
use App\Models\Order_request;
use App\Helper\CustomHelper;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders = Order_request::select('*')->where('order_id',$this->id)->get();

        return [
            'id' => $this->id,
            'address_from' => $this->address_from,
            'lat_from' => $this->lat_from,
            'long_from' => $this->long_from,
            'user_id' => $this->user_id,
            'username' => optional($this->user)->username,
            'status' => $this->status,
            'total_cost' => $this->total_cost,
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',
            'pick_up_type' => $this->pick_up_type,
            'order_date' => $this->order_date,
            'order_time' => $this->order_time,
            'activity_type_ids' => $this->activity_type_ids,
            'activity_type_name' =>$request->header("Language") == 'ar' ?$this->activity_type->pluck('name_ar')->implode(',') : $this->activity_type->pluck('name_en')->implode(','),
            'zone_id' => $this->zone_id,
            'zone_name' =>$request->header("Language") == 'ar' ? optional($this->zone)->name_ar : optional($this->zone)->name_en,

            'veichle_type_id ' => $this->veichle_type_id ,
            'veichle_type_name' =>$request->header("Language") == 'ar' ?optional($this->veichle_type)->name_ar : optional($this->veichle_type)->name_en,
            'order' => $orders

        ];
    }
}
