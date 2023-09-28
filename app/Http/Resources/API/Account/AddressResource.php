<?php

namespace App\Http\Resources\Api\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "address_type" => $this->addressType,
            "address" => $this->address,
            "is_primary" => $this->is_primary ? true : false,
            "city" => $this->city,
            "state" => $this->state,
            "pincode" => $this->pincode,
            "phone" => $this->phone,
            "latitude" => $this->latitude ?? null,
            "longitude" => $this->longitude ?? null,
        ];
    }
}
