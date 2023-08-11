<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanUsersResource extends JsonResource
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
            'first_name' => $this->user?->first_name,
            'last_name' => $this->user?->last_name,
            'email' => $this->user?->email,
            'mobile' => $this->user?->mobile,
            'start_at' => date("Y-m-d g:i:s A", $this->start_at),
            'end_at' => date("Y-m-d g:i:s A", $this->end_at),
        ];
    }
}
