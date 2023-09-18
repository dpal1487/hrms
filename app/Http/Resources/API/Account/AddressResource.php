<?php

namespace App\Http\Resources\Api\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "country" => $this->country?->name,
            "pincode" => $this->pincode,
            "phone" => $this->phone,
            "latitude" => $this->latitude ?? null,
            "longitude" => $this->longitude ?? null,
        ];
    }
}
