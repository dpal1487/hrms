<?php

namespace App\Http\Resources;

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
            'id' => $this->address?->id,
            'is_primary' => $this->address?->is_primary,
            'address_line_1' => $this->address?->address_line_1,
            'address_line_2' => $this->address?->address_line_2,
            'city' => $this->address?->city,
            'state' => $this->address?->state,
            'pincode' => $this->address?->pincode,
            'country' => $this->address?->country,
        ];
    }
}
