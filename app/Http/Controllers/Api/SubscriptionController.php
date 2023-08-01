<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\SubscriptionsResource;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
   public function active()
   {
      $subscriptions = Subscription::where('user_id', $this->uid())->where('end_at', '>', intval(now()->timestamp))->get();
      return SubscriptionsResource::collection($subscriptions);
   }
   public function expired()
   {
      $subscriptions = Subscription::where('user_id', $this->uid())->where('end_at', '<', intval(now()->timestamp))->get();
      return SubscriptionsResource::collection($subscriptions);
   }
}
