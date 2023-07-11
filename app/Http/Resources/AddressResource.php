<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'address'=>$this->address,
            'user'=>$this->user,
            'state'=>$this->state,
            'city'=>$this->city,
            'locality'=>$this->locality,
            'pincode'=>$this->pincode,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude
        ];
    }
}
