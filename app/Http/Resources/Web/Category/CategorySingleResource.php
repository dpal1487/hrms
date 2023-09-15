<?php

namespace App\Http\Resources\Web\Category;

use App\Http\Resources\Web\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorySingleResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'status' => $this->status,
            'image' => new ImageResource($this->image),
            'meta' => $this->meta,
            'parent' => $this->parent,
            'banner' => new ImageResource($this->banner?->banner),
            'attributes' => $this->attributes,
            'header' => [
                'total_active' => count($this->attributes->where('status', 1)),
                'total_value' => count($this->attributes)
            ]
        ];
    }
}
