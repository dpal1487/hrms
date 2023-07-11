<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'item_id' =>new ItemResource($this->item_id),
            'document_id' => $this->document_id,
            'full_name' => $this->full_name,
            'rental_status' => $this->rental_status,
            'rental_date' => $this->rental_date,
            'return_date' => $this->return_date,
            'mobile' => $this->mobile,
            'security_pay' => $this->security_pay,
            'email_address' => $this->email_address,
        ];
    }
}
