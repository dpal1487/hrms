<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'slug' => $this->slug,
            'time' => $this->time->title,
            'description' => $this->description,
            'rent_price' => $this->rent_price,
            'security_price' => $this->security_price,
            'status' => $this->status,
            'category' => $this->category,
            'image' => $this->image?->image,
            'location' => [
                'id' => $this->location?->address?->id,
                'address_line_1' => $this->location?->address?->address_line_1,
                'address_line_2' => $this->location?->address?->address_line_2,
                'city' => $this->location?->address?->city,
                'state' => $this->location?->address?->state,
                'country' => $this->location?->address?->country,
                'pincode' => $this->location?->address?->pincode,
            ],
            'rating_reviews' => count($this->reviews) > 0 ? [
                'count' => count($this->reviews)
            ] : [
                'rating' => 0,
                'count' => 0
            ],
            'item_customers' => count($this->customers) > 0 ? [
                'count' => count($this->customers)
            ] : [
                'customers' => 0,
                'count' => 0
            ],
            'item_visits' => count($this->visits) > 0 ? [
                'count' => count($this->visits)
            ] : [
                'visits' => 0,
                'count' => 0
            ],
        ];
    }
}
