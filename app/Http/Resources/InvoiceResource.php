<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'id' => $this->id,
            'company' => $this->company,
            'client' => $this->client,
            'gst_status' => $this->gst_status,
            'invoice_number' => $this->invoice_number,
            'invoice_date' => $this->invoice_date,
            'invoice_due_date' => $this->invoice_due_date,
            'total_amount_usd' => $this->total_amount_usd,
            'total_amount_inr' => $this->total_amount_inr,
            'notes' => $this->notes,
            'status' => $this->status,
            'company' => $this->company?->company,
            'company_address' => new AddressResource($this->company_address),
            'client_address' => new AddressResource($this->client_address),
            'client' => $this->client,
            'items' => $this->items,
            'currency' => $this->currency,


        ];
    }
}
