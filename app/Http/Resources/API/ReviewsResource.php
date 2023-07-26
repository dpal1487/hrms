<?php

namespace App\Http\Resources\Api;

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
            'review' => $this->review,
            'status' => $this->review?->status,
            'created_at' => date('y M d', strtotime($this->review?->created_at)),
            'updated_at' => $this->review?->updated_at,
            'user' => $this->user,
            'user_image' => $this->user->image
        ];
    }
}
