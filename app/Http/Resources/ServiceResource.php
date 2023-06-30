<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'image' => $this->image,
            'description' => $request->segment(3) == 'service' ? $this->description : substr($this->description, 0, 100),
            'page' => $this->page,
            'name' => $this->name,
            'slug' => $this->slug,
            'date' => date('d M,y', strtotime($this->created_at))
        ];
    }
}
