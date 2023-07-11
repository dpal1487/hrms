<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'name' => $this->name,
            'data_type' => $this->data_type,
            'category_id' => $this->category_id,
            'field' => $this->field,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'display_order	' => $this->display_order	,
            'status' => $this->status,
            'description' => $this->description,
            'category' =>$this->category,
            'values' => AttributeValueResource::collection($this->values),
            'rules' => AttributeRuleResource::collection($this->rules),

        ];
    }
}
