<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\Plans;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Models\Order;
use App\Models\Subscription;
use Exception;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Carbon\Carbon;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return Plans::collection($plans);
    }
    public function placeOrder(Plan $plan)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => now()->timestamp,
            'amount' => $plan->amount * 100,
            'currency' => $plan->currency,
        ]);
        $data = [
            'key' => env('RAZORPAY_KEY'),
            'amount' => $plan->amount * 100,
            'currency' => $plan->currency,
            'description' => $plan->description,
            'name' => $plan->name,
            'order_id' => $order->id,
        ];
        Order::create([
            'user_id' => $this->uid(),
            'plan_id' => $plan->id,
            'order_id' => $order->id,
            'amount' => $plan->amount,
            'status' => 'in progress'
        ]);
        return response()->json(['data' => $data, 'success' => true]);
    }
    public function razorPaySuccess(Request $request)
    {
        if (empty($request->payment_id) === false) {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            try {
                return $this->verifySignature($request);
            } catch (Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
        }
    }
    public function verifySignature(Request $request)
    {
        if (empty($request->payment_id) === false) {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            if (count($request->all())  && !empty($request->payment_id)) {
                try {
                    $attributes  = array('razorpay_signature'  => $request->signature,  'razorpay_payment_id'  => $request->payment_id,  'razorpay_order_id' => $request->order_id);
                    $api->utility->verifyPaymentSignature($attributes);
                    $order=Order::where('order_id', $request->order_id)->first();
                    $order->update([
                        'razorpay_signature' => $request->signature,
                        'razorpay_payment_id' => $request->payment_id,
                        'razorpay_order_id' => $request->order_id,
                        'status' => 'paid'
                    ]);

                    $payment = $api->payment->fetch($request->payment_id);
                    $data = [
                        'id' => $payment->id,
                        'amount' => $payment->amount,
                        'status' => $payment->status,
                        'created_at' => $payment->created_at,
                        'order_id' => $request->order_id,
                    ];
                    $plan = Plan::find($request->plan_id);

                    if (!Subscription::where(['user_id' => $this->uid(), 'payment_id' => $request->payment_id,
                    'order_id' => $order->id,])->first()) {
                        $id = Subscription::create([
                            'user_id' => $this->uid(),
                            'plan_id' => $request->plan_id,
                            'order_id' => $order->id,
                            'payment_id' => $request->payment_id,
                            'quantity' => 1,
                            'start_at' => now()->timestamp,
                            'end_at' => Carbon::now()->addDays($plan->expires_in_days)->timestamp,
                            'status' => 'created'
                        ]);
                        if(!Subscription::where(['user_id'=>$this->uid(),'status'=>'active'])->first()){
                            Subscription::where(['id'=>$id])->update(['status'=>'active']);
                        }
                    }
                    return response()->json(['message' => 'Verification success', 'data' => $data, 'success' => true], 200);
                } catch (SignatureVerificationError $e) {
                    return response()->json(['message' => 'Verification failed'], 400);
                }
            }
        }
    }
}
