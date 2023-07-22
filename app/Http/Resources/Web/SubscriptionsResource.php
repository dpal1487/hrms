<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsResource extends JsonResource
{
    public $api;
    public function __construct($api)
    {
        $this->api = $api;
    }
    public function toArray($request)
    {
        $subscription = $this->api->subscription->fetch($this->subscription_id);
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
            'start_date' => $subscription->start_date
        ];
    }
}
