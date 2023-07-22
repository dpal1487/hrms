<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->full_name,
            'rental_status' => $this->rental_status,
            'rental_date' => date('y M d', strtotime($this->rental_date)),
            'return_date' => date('y M d', strtotime($this->return_date)),
            'mobile' => $this->mobile,
            'security_pay' => $this->security_pay,
            'email_address' => $this->email_address,
            'document' => $this->document,
        ];
    }
}
