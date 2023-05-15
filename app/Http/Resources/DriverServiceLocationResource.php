<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverServiceLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'zone_id' => $this->zone_id,
            // 'zone_name' =>$request->header("Language") == 'ar' ? $this->zone_name->pluck('name_ar')->implode(',') : $this->zone_name->pluck('name_en')->implode(','),
            'veichle_type_name' =>$request->header("Language") == 'ar' ?optional($this->veichle_type)->name_ar : optional($this->veichle_type)->name_en,
            'vehicle_brand_name' =>$request->header("Language") == 'ar' ?optional($this->vehicle_brand)->name_ar : optional($this->vehicle_brand)->name_en,
            'vehicle_model' =>$request->header("Language") == 'ar' ?optional($this->vehicle_model)->name_ar : optional($this->vehicle_model)->name_en,
            'vehicle_color' =>$request->header("Language") == 'ar' ?optional($this->vehicle_color)->name_ar : optional($this->vehicle_color)->name_en,
            'vehicle_year' => $this->vehicle_year,
            'vehicle_plate_number' => $this->vehicle_plate_number,
            'profile_image' => $this->getFirstMediaUrl('profile_image'),
            'driver_licnse' => $this->getFirstMediaUrl('driver_licnse'),
            'registration_sicker' => $this->getFirstMediaUrl('registration_sicker'),
            'vehicle_insurance' => $this->getFirstMediaUrl('vehicle_insurance'),
        ];
    }
}
