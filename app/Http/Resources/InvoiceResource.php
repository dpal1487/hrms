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
            'client_id' => $this->client_id,
            'company_id' => $this->company_id,
            'gst_status' => $this->gst_status,
            'invoice_number' => $this->invoice_number,
            'conversion_rate' => $this->conversion_rate,
            'invoice_date' => $this->invoice_date,
            'invoice_due_date' => $this->invoice_due_date,
            'total_amount_usd' => $this->total_amount_usd,
            'total_amount_inr' => $this->total_amount_inr,
            'notes' => $this->notes,
            'status' => $this->status,
            'company' => $this->company,
            'client' => $this->client,
            'item' => $this->item,
        ];
    }
}
