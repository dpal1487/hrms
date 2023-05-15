<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'id' => $this->account?->id,
            'bank_name' => $this->account?->bank_name,
            'bank_address' => $this->account?->bank_address,
            'beneficiary_name' => $this->account?->beneficiary_name,
            'account_number' => $this->account?->account_number,
            'routing_number' => $this->account?->routing_number,
            'swift_code' => $this->account?->swift_code,
            'ifsc_code' => $this->account?->ifsc_code,
            'sort_code' => $this->account?->sort_code,
            'pan_number' => $this->account?->pan_number,
        ];
    }
}
