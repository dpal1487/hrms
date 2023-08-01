<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
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
            "id" => $this->id,
            "full_name" => $this->full_name,
            "rental_status" => $this->rental_status,
            "rental_date" => $this->rental_date,
            "mobile" => $this->mobile,
            "security_pay" => $this->security_pay,
            "email_address" => $this->email_address,
            "created_at" => date('Y-m-d H:i:s', strtotime($this->created_at)),
            "updated_at" => date('y M d m:s', strtotime($this->updated_at)),
            "item" => $this->item,
            "document" => [
                "id" => $this->document->id,
                "file_name" => $this->document?->file_name,
                "file_path" => $this->document?->file_path,
                "file_size" => $this->document?->file_size,
                "file_mime" => $this->document?->file_mime,
                "file_extension" => $this->document?->file_extension,
                "status" => $this->document?->status,
                "created_at" => $this->document?->created_at,
                "updated_at" => $this->document?->updated_at,
            ]
        ];
    }
}
