<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
            'title' => $request->header("Language") == 'ar' ? $this->title : $this->title_en,
            'text' => $request->header("Language") == 'ar' ? strip_tags($this->text) : strip_tags($this->text_en),
        ];
    }
}
