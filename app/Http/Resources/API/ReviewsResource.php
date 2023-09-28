<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\Account\UserResource;
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
            'rating' => $this->review?->rating,
            'likes_count' => $this->review?->likes_count,
            'user_liked' => $this->review?->reviewLike?->user_id == $this->user->id,
            'status' => $this->review?->status,
            'created_at' => date('y M d', strtotime($this->review?->created_at)),
            'updated_at' => $this->review?->updated_at,
            'user' => new UserResource($this->user),   
            'review' => $this->review,
        ];
    }
}
