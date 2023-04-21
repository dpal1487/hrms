<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id' =>$this->id,
            'company_type' =>$this->company_type,
            'subdomain' =>$this->subdomain,
            'company_size_id' =>$this->company_size_id,
            'corporation_type_id' =>$this->corporation_type_id,
            'contact_email' =>$this->contact_email,
            'tax_number' =>$this->tax_number,
            'company_name' =>$this->company_name,
            'description' =>$this->description,
            'website' =>$this->website,
            'user'=>$this->user,
        ];
    }
}
