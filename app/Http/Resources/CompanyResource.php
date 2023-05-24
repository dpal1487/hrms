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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'company_type' => $this->company_type,
            'company_size_id' => $this->company_size_id,
            'corporation_type_id' => $this->corporation_type_id,
            'legal_registration_no' => $this->legal_registration_no,
            'description' => $this->description,
            'website' => $this->website,
            'subdomain' => $this->subdomain,
            'linkedin_profile' => $this->linkedin_profile,
            'skype_profile' => $this->skype_profile,
            'tax_number' => $this->tax_number,
            'company_name' => $this->company_name,
            'account_plan' => $this->account_plan,
            'user' => $this->user,
            'size' => $this->size,
            'corporationtype' => $this->corporationtype,

        ];
    }
}
