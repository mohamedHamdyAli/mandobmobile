<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'zone_id' => $this->zone_id,
            'zone' =>$request->header("Language") == 'ar' ?$this->zone_name->pluck('name_ar')->implode(',') : $this->zone_name->pluck('name_en')->implode(','),
            'profile_image' => $this->getFirstMediaUrl('profile_image'),


        ];
    }
}
