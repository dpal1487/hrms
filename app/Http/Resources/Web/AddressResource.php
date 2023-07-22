<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'id' => $this->address->id,
            'address_line_1' => $this->address->address_line_1,
            'address_line_2' => $this->address->address_line_2,
            'state' => $this->address->state,
            'city' => $this->address->city,
            'locality' => $this->address->locality,
            'pincode' => $this->address->pincode,
            'latitude' => $this->address->latitude,
            'longitude' => $this->address->longitude,
            'country' => $this->address->country,
        ];
    }
}
