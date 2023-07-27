<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'category' => $this->category,
            'models' => $this->models,
            'image' => new ImageResource($this->image),

            'header' => [
                'total_active' => count($this->models->where('status', 1)),
                'total_value' => count($this->models),
            ],
            'models' => BrandModelResource::collection($this->models),
        ];
    }
}
