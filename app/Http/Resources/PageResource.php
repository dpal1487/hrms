<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'title' =>$this->title,
            'heading' =>$this->heading,
            'status' =>$this->status,
            'meta' =>$this->meta,
        ];
    }
}
