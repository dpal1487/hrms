<?php

namespace App\Http\Resources\Api;

use Carbon\Carbon;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "base_url" => $this->base_url,
            "category" => new CategoryResource($this->category),
            "time" => $this->time?->title,
            "description" => $this->description,
            "rent_price" => $this->rent_price,
            "security_price" => $this->security_price,
            "from_date" => date('y M d', strtotime($this->from_date)),
            "to_date" => date('y M d', strtotime($this->to_date)),
            "status" => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            "updated_at" => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
