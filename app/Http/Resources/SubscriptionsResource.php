<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'payment_id' => $this->payment_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'user' =>$this->user,
            'plan' =>$this->plan,
            'order' =>$this->order,
            // 'payment' =>$this->payment,
        ];
    }
}
