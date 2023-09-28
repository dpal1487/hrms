<?php

namespace App\Http\Resources\Web\Item;

use App\Http\Resources\Web\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewReportResource extends JsonResource
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
            'review_title' => $this->report?->review?->title,
            'review_content' => $this->report?->review?->content,
            'review' => $this->report?->review,
            'user' => new UserResource($this->report?->user),
        ];
    }
}
