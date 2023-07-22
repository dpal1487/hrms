<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'name' => $this->image?->name,
            'small_path' => $this->image?->small_path,
            'medium_path' => $this->image?->medium_path,
            'large_path' => $this->image?->large_path,
        ];
    }
}
