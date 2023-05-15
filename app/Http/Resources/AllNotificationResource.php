<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllNotificationResource extends JsonResource
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
            'created_at' => $this->created_at->diffForHumans(),
            // 'date' => $this->created_at->format('Y-m-d'),
            // 'time' => date("g:i a", strtotime($this->created_at)),
            'datetime' => date('j F',strtotime($this->created_at)) . ' '. date("g:i a", strtotime($this->created_at)),
            'title' => $request->header("Language") == 'ar' ? $this->title_ar : $this->title,
            'body' => $request->header("Language") == 'ar' ? $this->body_ar : $this->body,
            'order_id' => $this->order_id,
        ];
    }
}
