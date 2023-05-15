<?php

namespace App\Http\Resources;
use App\Helper\CustomHelper;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverWalletResource extends JsonResource
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
            'wallet' => $this->wallet,
            'date_wallet' => date('F j, Y',strtotime($this->date)),
            'time_wallet' =>  date("g:i a", strtotime($this->time)),

        ];
    }
}
