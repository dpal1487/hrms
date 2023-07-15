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
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'user' => $this->user,
            'plan' => $this->plan,
            'order_id' => $this->order_id,
            'start_at' => date("Y-m-d H:i:s", $this->start_at),
            'end_at' => date("Y-m-d H:i:s", $this->end_at),
        ];
    }
}
