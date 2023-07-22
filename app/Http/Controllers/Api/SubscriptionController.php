<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Subscriptions;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function active(){
      $subscriptions = Subscription::where('user_id',$this->uid())->where('end_at','>',intval(now()->timestamp))->get();
       return Subscriptions::collection($subscriptions);
    }
   public function expired(){
      $subscriptions = Subscription::where('user_id',$this->uid())->where('end_at','<',intval(now()->timestamp))->get();
       return Subscriptions::collection($subscriptions);
   }
}
