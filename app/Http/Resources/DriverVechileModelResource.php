<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverVechileModelResource extends JsonResource
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
            'name' => $request->header("Language") == 'ar' ? $this->name_ar : $this->name_en,
            'vehicle_brand_name' =>$request->header("Language") == 'ar' ?optional($this->vehicle_brand)->name_ar : optional($this->vehicle_brand)->name_en,
        ];
    }
}
