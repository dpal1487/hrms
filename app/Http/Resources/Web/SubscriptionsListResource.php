<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;
use Razorpay\Api\Api;

class SubscriptionsListResource extends JsonResource
{
    private $api;
    // function __construct()
    // {
    //     $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    // }
    public function toArray($request)
    {
        // $subscription = $this->api->subscription->fetch("sub_00000000000001");
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'subscription_id' => $this->subscription_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'user' => $this->user,
            'plan' => $this->plan,
            'order_id' => $this->order_id,
            'start_at' => date("Y-m-d H:i:s", $this->start_at),
            'end_at' => date("Y-m-d H:i:s", $this->end_at),
            // 'start_date' => $subscription->start_date
        ];
    }
}
