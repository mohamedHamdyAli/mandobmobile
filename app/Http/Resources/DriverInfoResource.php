<?php

namespace App\Http\Resources;

use App\Models\DriverRate;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $rate = DriverRate::where('driver_id', $this->id)->get();
            $order_count = $rate->count();
            $driver_rate = $rate->sum('rate');
            if($order_count != 0)
                $final_rate = $driver_rate / $order_count;
            else
                $final_rate = 0;
        return [
            'id' => $this->id,
            'username' => $this->username,
            'phone' => $this->phone,
            'profile_image' => $this->getFirstMediaUrl('profile_image'),
            'vehicle_plate_number' => $this->vehicle_plate_number,
            'vehicle_brand_id' => $this->vehicle_brand_id,
            'vehicle_brand_name' =>$request->header("Language") == 'ar' ?optional($this->vehicle_brand)->name_ar : optional($this->vehicle_brand)->name_en,
            'vehicle_model_id' => $this->vehicle_model_id,
            'vehicle_model' =>$request->header("Language") == 'ar' ?optional($this->vehicle_model)->name_ar : optional($this->vehicle_model)->name_en,
            'vehicle_color_id' => $this->vehicle_color_id,
            'vehicle_color' =>$request->header("Language") == 'ar' ?optional($this->vehicle_color)->name_ar : optional($this->vehicle_color)->name_en,
            'rate' => $final_rate,
        ];
    }
}
