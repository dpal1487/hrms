<?php

namespace App\Http\Resources;

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
            'item_id' => $this->item_id,
            'attribute_id' => $this->attribute_id,
            'attribute_value' => $this->attribute_value,
        ];
    }
}
