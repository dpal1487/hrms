<?php

namespace App\Http\Resources\Web\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'name' => $this->attribute?->name,
            'data_type' => $this->attribute?->data_type,
            'field' => $this->attribute?->field,
            'type' => $this->attribute?->type,
            'status' => $this->attribute?->status,
        ];
    }
}
