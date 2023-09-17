<?php

namespace App\Http\Resources\Api\Account;
use App\Http\Resources\Api\ItemListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteListResource extends JsonResource
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
            'item'=>new ItemListResource($this->item)
        ];
    }
}
