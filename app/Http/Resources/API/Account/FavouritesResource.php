<?php

namespace App\Http\Resources\Api\Account;

use App\Http\Resources\Api\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouritesResource extends JsonResource
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
            'item' => new ItemResource($this->item),
            'user' => new UserResource($this->user),
        ];
    }
}
