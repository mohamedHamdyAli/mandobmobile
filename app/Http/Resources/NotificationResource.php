<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'read_at' => $this->read_at,
            'created_at2' => $this->created_at->diffForHumans(),
            'title' => $request->header("Language") == 'ar' ? $this->data['title_ar'] : $this->data['title'],
            'body' => $request->header("Language") == 'ar' ? $this->data['body_ar'] : $this->data['body'],
        ];
    }
}
