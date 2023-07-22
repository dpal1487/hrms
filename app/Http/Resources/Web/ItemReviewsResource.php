<?php

namespace App\Http\Resources\Web;

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
            'user' => $this->user->image,
            'reviews' => ReviewResource::collection($this->reviews),
            'review' => $this->review,
            'category' => $this->category,
            'item' => $this->name,
            'rating_reviews' => count($this->reviews) > 0 ? [
                'count' => count($this->reviews)
            ] : [
                'rating' => 0,
                'count' => 0
            ],
        ];
    }
}
