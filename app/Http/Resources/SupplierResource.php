<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'supplier_name' => $this->supplier_name,
            'display_name' => $this->display_name,
            'website' => $this->website,
            'skype_profile' => $this->skype_profile,
            'linkedIn_profile' => $this->linkedIn_profile,
            'description' => $this->description,
            'status' => $this->status,
            'company' => $this->company,    
        ];
    }
}
