<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class UserReviewsResource extends JsonResource
{
    public function toArray($request)
    {
        return
            [
                'id' => $this->review->id,
                'title' => $this->review->title,
                'content' => $this->review->content,
                'rating' => $this->review->rating,
                'status' => $this->review->status,
                'created_at' => date('y M d', strtotime($this->review->created_at)),
                'updated_at' => date('y M d', strtotime($this->review->updated_at)),
                'user' => $this->user,
            ];
    }
}
