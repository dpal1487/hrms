<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [

            'ip_address' => $this->ip_address,
            'user' => $this->user,
            'id' => $this->review->id,
            'title' => $this->review->title,
            'content' => $this->review->content,
            'rating' => $this->review->rating,
            'status' => $this->review->status,
            'created_at' => date('y M d', strtotime($this->review->created_at)),
            'updated_at' => date('y M d', strtotime($this->review->updated_at)),
        ];
    }
}
