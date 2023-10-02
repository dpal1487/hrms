<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeListResource extends JsonResource
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
            'id' => $this->attribute?->id,
            'name' => $this->attribute?->name,
            'data_type' => $this->attribute?->data_type,
            'field' => $this->attribute?->field,
            'type' => $this->attribute?->input_type,
            'display_order' => $this->attribute?->display_order,
            'status' => $this->attribute?->status,
            'description' => $this->attribute?->description,
            'values'=>AttributeValueListResource::collection($this->attribute->values),
        ];
    }
}
