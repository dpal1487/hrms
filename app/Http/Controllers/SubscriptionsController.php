<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Resources\SubscriptionsResource;
use DB;
use Inertia\Inertia;

class SubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subscriptions = new Subscription();
        if (!empty($request->q)) {
            $subscriptions = $subscriptions->where('order_id', 'like', "%{$request->q}%")->orWhere('payment_id', 'like', "%{$request->q}%")
                ->orWhereHas('plan', function ($plan) use ($request) {
                    $plan->where('plan_id', 'like', "%{$request->q}%");
                })
                ->orWhereHas('user', function ($user) use ($request) {
                    $user->where('first_name', 'like', "%{$request->q}%")->orWhere('first_name', 'like', "%{$request->q}%");
                });
        }
        if (!empty($request->s) || $request->s != '') {
            $subscriptions = $subscriptions->where('status', $request->s);
        }
        return Inertia::render('Subscriptions/Index', [

            'subscriptions' => SubscriptionsResource::collection($subscriptions->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
}
