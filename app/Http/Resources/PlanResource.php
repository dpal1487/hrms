<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => $this->category,
            'no_of_ads' => $this->no_of_ads,
            'slug' => $this->slug,
            'name' => $this->name,
            'sort_description' => $this->sort_description,
            'description' => $this->description,
            'status' => $this->status,
            'price' => $this->price,
            'signup_fee' => $this->signup_fee,
            'sort_order' => $this->sort_order,
        ];
    }
}
