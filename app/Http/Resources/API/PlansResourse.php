<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PlansResourse extends JsonResource
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
            'period' => $this->period,
            'currency' => $this->currency,
        ];
    }
}
