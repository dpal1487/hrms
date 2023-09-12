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
            'id' => $this->id,
            'name' => $this->name,
            'data_type' => $this->data_type,
            'field' => $this->field,
            'type' => $this->type,
            'display_order' => $this->display_order,
            'status' => $this->status,
            'description' => $this->description,
            'values'=>AttributeValueListResource::collection($this->values),
        ];
    }
}
