<?php

namespace App\Http\Resources;
use App\Helper\CustomHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverOrderResource extends JsonResource
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
            'id' => $this->order_id,
            'address_from' => $this->address_from,
            'total_cost' => $this->total_cost,
            'status' => $this->status == 'cancel' ? 'pending' : 'pending',
            'order_date' => date('F j, Y',strtotime($this->order_date)),
            'order_time' => date('g:i a',strtotime($this->order_time)),
            'currency' => $request->header("Language") == 'en' ? (new CustomHelper)->setting_data('currency') : 'دينار',

        ];
    }
}
