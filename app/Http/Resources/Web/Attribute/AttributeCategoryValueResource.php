<?php

namespace App\Http\Resources\Web\Attribute;

use App\Http\Resources\Web\Category\CategorySingleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeCategoryValueResource extends JsonResource
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
            'category' =>new AttributeValueResource($this->attributeCategory),
            'id' =>$this->id,
            'attribute_value' =>$this->attribute_value,
            'attribute' =>$this->attribute?->name,
            'attribute_id' =>$this->attribute?->id,
            'status' =>$this->status,
        ];
    }
}
