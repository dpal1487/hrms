<?php

namespace App\Http\Resources\Web\Attribute;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeShowResource extends JsonResource
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
            'category_id' => $this->category_id,
            'field' => $this->field,
            'parent_id' => $this->parent_id,
            'input_type' => $this->input_type,
            'display_order' => $this->display_order,
            'status' => $this->status,
            'description' => $this->description,
            'category' => $this->category,
            'header' => [
                'total_active' => $this->values ?  count($this->values->where('status', 1)) : 0,
                'total_value' => $this->values ? count($this->values) : 0,
            ],
            'rules' => $this->rules ? AttributeRuleResource::collection($this->rules) : array(),
            'categories' => $this->categories ? AttributeCategoryResource::collection($this->categories) : array(),
        ];
    }
}
