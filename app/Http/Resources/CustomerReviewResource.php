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
            'review' =>new ReviewResource($this->review)
        ];
    }
}
