<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPackagesResource extends JsonResource
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
            'id' => $this->plan->id,
            'period' => $this->plan->period,
            'interval' => $this->plan->interval,
            'subscription_id' => $this->subscription_id,
            'plan_id' => $this->plan->plan_id,
            'no_of_ads' => $this->plan->no_of_ads,
            'name' => $this->plan->name,
            'sort_description' => $this->plan->sort_description,
            'description' => $this->plan->description,
            'status' => $this->plan->status,
            'price' => $this->plan->price,
            'currency' => $this->plan->currency,
            'sort_order' => $this->plan->sort_order,
            'created_at' => date('y M d', strtotime($this->plan->created_at)),
            'updated_at' => date('y M d', strtotime($this->plan->updated_at)),
        ];
    }
}
