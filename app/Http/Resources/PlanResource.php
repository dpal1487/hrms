<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sort_description' => $this->sort_description,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'interval' => $this->interval,
            'stripe_plan' => $this->stripe_plan,
            'price' => $this->price,
            'sort_order' => $this->sort_order,
            'currency' => $this->currency,
        ];
    }
}
