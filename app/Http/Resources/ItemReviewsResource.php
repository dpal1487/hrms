<?php

namespace App\Http\Resources;

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
            'user' => $this->user,
            'reviews' => ReviewResource::collection($this->reviews),
            'review' => $this->review,

            // 'time' => $this->time->title,
            // 'description' => $this->description,
            // 'from_date' => date("d M Y", strtotime($this->from_date)),
            // 'to_date' => date("d M Y", strtotime($this->to_date)),
            // 'category' => $this->category,
            // 'images' => ImageResource::collection($this->images),
            // 'user' => $this->user,
            // 'reviews' => ReviewResource::collection($this->reviews),
            // 'rating_reviews' => count($this->reviews) > 0 ? [
            //     'count' => count($this->reviews)
            // ] : [
            //     'rating' => 0,
            //     'count' => 0
            // ],
            // 'item_customers' => count($this->customers) > 0 ? [
            //     'count' => count($this->customers)
            // ] : [
            //     'customers' => 0,
            //     'count' => 0
            // ],
            // 'item_visits' => count($this->visits) > 0 ? [
            //     'count' => count($this->visits)
            // ] : [
            //     'visits' => 0,
            //     'count' => 0
            // ],
        ];
    }
}
