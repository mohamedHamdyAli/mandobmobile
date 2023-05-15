<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverVechileOnfoResource extends JsonResource
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
            'vehicle_brand_id' => $this->vehicle_brand_id,
            'vehicle_brand_name' =>$request->header("Language") == 'ar' ?optional($this->vehicle_brand)->name_ar : optional($this->vehicle_brand)->name_en,
            'vehicle_model_id' => $this->vehicle_model_id,
            'vehicle_model' =>$request->header("Language") == 'ar' ?optional($this->vehicle_model)->name_ar : optional($this->vehicle_model)->name_en,
            'vehicle_color_id' => $this->vehicle_color_id,
            'vehicle_color' =>$request->header("Language") == 'ar' ?optional($this->vehicle_color)->name_ar : optional($this->vehicle_color)->name_en,
            'vehicle_year' => $this->vehicle_year,
            'vehicle_plate_number' => $this->vehicle_plate_number,
        ];
    }
}
