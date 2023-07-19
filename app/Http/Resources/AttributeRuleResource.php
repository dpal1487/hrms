<?php

namespace App\Http\Resources;

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
            'rule' => $this->attributeRule->rule,
            'value' => $this->attributeRule->value,
            'message' => $this->attributeRule->message,
        ];
    }
}
