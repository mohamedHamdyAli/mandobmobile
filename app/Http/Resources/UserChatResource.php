<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class UserChatResource extends JsonResource
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
            ->where('flag', 0)
            ->where('read', 'false')
            ->count();
        $date = Chat::select('date','time')->where('order_id', $this->order_id)->orderBy('id', 'desc')->first();

        return [
            'id' => $this->id,
            'status' => $this->status,
            'driver_id' => $this->driver_id,
            'user_id' => $this->user_id,
            'order_id' => $this->order_id,
            'read' => $this->read,
            'count' => $chatss,
            'profile_image' => $this->driver->getFirstMediaUrl('profile_image'),
            'datatime' => $date == null ? '' : date('F j',strtotime($date->date)). ','.date('g:i a',strtotime($date->time)),
        ];
    }
}
