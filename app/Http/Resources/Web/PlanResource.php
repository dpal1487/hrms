<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'no_of_ads' => $this->no_of_ads,
            'slug' => $this->slug,
            'sort_description' => $this->sort_description,
            'description' => $this->description,
            'status' => $this->status,
            'price' => $this->price,
            'plan_id' => $this->plan_id,
            'signup_fee' => $this->signup_fee,
            'sort_order' => $this->sort_order,
            'period' => $this->period,
            'currency' => $this->currency,
            'category' => $this->category,
            'created_at' => date('y M d', strtotime($this->created_at)),
            'updated_at' => date('y M d', strtotime($this->updated_at)),
            'headers' => [
                'earnings' => ($this->price) * count($this->subcriptions),
                'total' => $this->subcriptions ? count($this->subcriptions) : 0,
                'active' => $this->subcriptions ? count($this->subcriptions->where('status', 'created')) : 0,
                'in_active' => $this->subcriptions ? count($this->subcriptions->where('status', 'deleted')) : 0,
            ],
            'reports' => [
                // 'total_projects' => count($this->projects),
                // 'live_projects' => count($this->projects->where('status', 'live')),
                // 'hold_projects' => count($this->projects->where('status', 'hold')),
                // 'close_projects' => count($this->projects->where('status', 'close')),
            ]

        ];
    }
}
