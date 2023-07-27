<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'keywords' => $this->keywords,
            'status' => $this->status,
            'image' => new ImageResource($this->image),
            'meta' => $this->meta,
            'banner' =>new ImageResource($this->banner?->banner),
            'parent' => $this->parent,
        ];
    }
}
