<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'driver_id' => $this->driver_id,
            'driver_name' => optional($this->driver)->username,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->username,
            'message' => $this->message,
            'flag' => $this->flag,
            'date' => date('F j, Y',strtotime($this->date)),
            'time' =>  date("g:i a", strtotime($this->time)),
            'read' => $this->read,


        ];
    }
}
