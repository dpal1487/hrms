<?php

namespace App\Http\Resources\Api\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
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
            'id' => $this->review?->id,
            'title' => $this->review?->title,
            'content' => $this->review?->content,
            "rating" => $this->review?->rating,
            "status" => $this->review?->status,
            'status' => $this->review?->status,
            'user' => new UserResource($this->user),
        ];
    }
}
