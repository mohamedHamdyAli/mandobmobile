<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $chatss = Chat::where('user_id', '=', $this->user_id)
        ->where('driver_id', '=', $this->driver_id)
        ->where('order_id', $this->order_id)
        ->where('flag', 1)
        ->where('read', 'false')
        ->count();

        $date = Chat::select('date','time')->where('order_id', $this->order_id)->orderBy('id', 'desc')->first();
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'driver_id' => $this->driver_id,
            'order_id' => $this->order_id,
            'read' => $this->read,
            'count' => $chatss,
            'profile_image' => $this->user->getFirstMediaUrl('profile_image'),
            'datatime' => $date == null ? '' : date('F j',strtotime($date->date)). ','.date('g:i a',strtotime($date->time)),
        ];
    }
}
