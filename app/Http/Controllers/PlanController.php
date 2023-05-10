<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = new Plan();
        if (!empty($request->q)) {
            $plans = $plans
                ->where('currency_name', 'like', "%$request->q")
                ->orWhere('currency_value', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $plans = $plans->where('status', '=', $request->status);
        }
        return Inertia::render('Plan/Index', [
            'plans' => PlanResource::collection($plans->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('Plan/Form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'short_order' => 'required',
            'stripe_id' => 'required',
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $plan = Plan::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'sort_order' => $request->short_order,
            'stripe_id' => $request->stripe_id,
            'currency' => $request->currency,
        ]);
        if ($plan) {
            // return response()->json(['success' => true, 'message' => 'ConversionRate created successfully']);

            return redirect('/plan')->with(['message' => 'Plan Rate created successfully'], 200);
        }
        return redirect('/plan')->with(['message' => 'Plan Rate Not created'], 400);
    }

    public function edit($id)
    {
        $plan = Plan::find($id);

        return Inertia::render('Plan/Form', [
            'plan' => new PlanResource($plan),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'short_order' => 'required',
            'stripe_id' => 'required',
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $conversionrate = Plan::find($id);

        if (
            $conversionrate = Plan::where(['id' => $conversionrate->id])->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'status' => $request->status,
                'price' => $request->price,
                'sort_order' => $request->short_order,
                'stripe_id' => $request->stripe_id,
                'currency' => $request->currency,
            ])
        ) {
            return redirect('/plan')->with(['message' => 'Conversion Rate Updated successfully']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong !',
                'redirect' => '/address',
            ]);
        }
    }

    public function destroy($id)
    {
        // dd($id);

        $conversionrate = Plan::find($id);
        if ($conversionrate->delete()) {
            return response()->json(['success' => true, 'message' => 'Conversion Rate has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
