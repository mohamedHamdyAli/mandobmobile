<?php

namespace App\Http\Resources;
use App\Models\Order_request;
use App\Helper\CustomHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $orders = Order_request::select('id','address_to','lat_to','long_to','order_name','phone','client_name')->where('order_id',$this->id)->get();

        return [
            'id' => $this->id,
            'address_from' => $this->address_from,
            'long_from' => $this->long_from,
            'lat_from' => $this->lat_from,
            'total_cost' => $this->total_cost,
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',
            'user_id' => $this->user_id,
            'pick_up_username' => optional($this->user)->username,
            'profile_image' => $this->user->getFirstMediaUrl('profile_image'),
            'pick_up_phone' => optional($this->user)->phone,
            'veichle_type_name' =>$request->header("Language") == 'ar' ?optional($this->veichle_type)->name_ar : optional($this->veichle_type)->name_en,
            'order_date' => $this->order_date,
            'order_time' => $this->order_time,
            'status' => $this->status,
            'order' => $orders

        ];
    }
}
