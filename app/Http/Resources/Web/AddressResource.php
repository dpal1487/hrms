<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->address?->id,
            'name' => $this->address?->name,
            'phone' => $this->address?->phone,
            'address' => $this->address?->address,
            'state' => $this->address?->state,
            'city' => $this->address?->city,
            'locality' => $this->address?->locality,
            'pincode' => $this->address?->pincode,
            'latitude' => $this->address?->latitude,
            'longitude' => $this->address?->longitude,
        ];
    }
}
