<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeRuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->attributeRule->id,
            'rule' => $this->attributeRule->rule,
            'value' => $this->attributeRule->value,
            'message' => $this->attributeRule->message,
        ];
    }
}