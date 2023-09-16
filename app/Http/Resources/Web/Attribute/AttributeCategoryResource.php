<?php

namespace App\Http\Resources\Web\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeCategoryResource extends JsonResource
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
            'category_name' => $this->category?->name,
            // 'name' => $this->attributeCategory->name,
            // 'slug' => $this->attributeCategory->slug,
        ];
    }
}

