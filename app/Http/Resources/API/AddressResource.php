<?php

namespace App\Http\Resources\Api;

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
            "address_line_1" => $this->address_line_1,
            "address_line_2" => $this->address_line_2,
            "city" => $this->city,
            "state" => $this->state,
            "country" => $this->country->name,
            "pincode" => $this->pincode,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }
}
