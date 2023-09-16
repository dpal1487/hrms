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
            'id' => $this->categoryAttribute?->id,
            'name' => $this->categoryAttribute?->name,
            'slug' => $this->categoryAttribute?->slug,
        ];
    }
}

