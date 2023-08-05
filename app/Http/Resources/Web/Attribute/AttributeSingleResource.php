<?php

namespace App\Http\Resources\Web\Attribute;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeSingleResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'data_type' => $this->data_type,
            'category_id' => $this->category_id,
            'field' => $this->field,
            'parent_id' => $this->parent_id,
            'type' => $this->type,
            'display_order' => $this->display_order,
            'status' => $this->status,
            'description' => $this->description,
            'category' => $this->category,  
            'header' => [
                'total_active' => count($this->values->where('status', 1)),
                'total_value' => count($this->values),
            ],
            'values' => AttributeValueResource::collection($this->values),
            'rules' => AttributeRuleResource::collection($this->rules),
        ];
    }
}
