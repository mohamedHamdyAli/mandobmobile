<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class UserResource extends JsonResource
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
            'zone_name' =>$request->header("Language") == 'ar' ? optional($this->zone)->name_ar : optional($this->zone)->name_en,
            'profile_image' => $this->getFirstMediaUrl('profile_image'),


        ];
    }
}
