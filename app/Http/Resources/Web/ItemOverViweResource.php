<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemOverViweResource extends JsonResource
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
            'title' => $this->name,
            'time' => $this->time->title,
            'description' => $this->description,
            'rent_price' => $this->rent_price,
            'security_price' => $this->security_price,
            'from_date' => date("d M Y", strtotime($this->from_date)),
            'to_date' => date("d M Y", strtotime($this->to_date)),
            'category' => $this->category,
            'attributes' => ItemAttributeResource::collection($this->attributes),
            'location' => [
                'id' => $this->location?->address?->id,
                'address_line_1' => $this->location?->address?->address_line_1,
                'address_line_2' => $this->location?->address?->address_line_2,
                'city' => $this->location?->address?->city,
                'state' => $this->location?->address?->state,
                'country' => $this->location?->address?->country,
                'pincode' => $this->location?->address?->pincode,
            ],
            'images' => ImageResource::collection($this->images),
            'user' => $this->user,
            'rating_reviews' => count($this->reviews) > 0 ? [
                'count' => count($this->reviews)
            ] : [
                'rating' => 0,
                'count' => 0
            ],
            'reviews' => ReviewResource::collection($this->reviews),

        ];
    }
}
