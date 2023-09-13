<?php

namespace App\Http\Resources\Api\Account;

use App\Http\Resources\Api\ImageResource;
use App\Http\Resources\Api\ItemResource;
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
            'item_id' => $this->item->id,
            'title' => $this->item->name,
            'base_url' => $this->item->base_url,
            'time' => $this->item->time->title,
            'image' => new ImageResource($this->item->image),
            'rent_price' => $this->item->rent_price,
            'security_price' => $this->item->security_price,
            'currency_symbol' => $this->item->user->country->currency_symbol,
            'location' => new AddressResource($this->item->location),
            'isFavourite' => $this->item->isFavourite ? true : false,
        ];
    }
}
