<?php

namespace App\Http\Resources\Web\Item;

use App\Http\Resources\Web\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'item' => $this->name,
            'category' => $this->category,
            'review' => $this->review,
            'image' => new ImageResource($this->image),
            'reviews' => ItemUserResource::collection($this->reviews),
            'rating_reviews' => count($this->reviews) > 0 ? [
                'count' => count($this->reviews)
            ] : [
                'rating' => 0,
                'count' => 0
            ],

        ];
    }
}
