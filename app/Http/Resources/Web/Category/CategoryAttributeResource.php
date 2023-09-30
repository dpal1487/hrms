<?php

namespace App\Http\Resources\Web\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAttributeResource extends JsonResource
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
            'id' => $this->attribute->id,
            'name' => $this->attribute->name,
            'slug' => $this->attribute->slug,
            'description' => $this->attribute->description,
            'status' => $this->attribute->status,
        ];
    }
}
