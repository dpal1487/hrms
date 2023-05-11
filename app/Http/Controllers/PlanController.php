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
                ->where('name', 'like', "%$request->q")
                ->orWhere('description', 'like', "%$request->q%")
                ->orWhere('currency', 'like', "%$request->q%")
                ->orWhere('price', 'like', "%$request->q%")
                ->orWhere('stripe_id', 'like', "%$request->q%");
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

    public function store(Plan $plan, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'unique:plans,slug',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'sort_order' => 'required',
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
            'sort_order' => $request->sort_order,
            'stripe_id' => $request->stripe_id,
            'currency' => $request->currency,
        ]);
        if ($plan) {
            return response()->json([
                'success' => true,
                'message' => 'Plan created successfully'

            ], 200);

            // return redirect('/plan')->with(['message' => 'Plan Rate created successfully'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Plan create fail successfully'], 200);

        // return redirect('/plan')->with(['message' => 'Plan Rate Not created'], 400);

    }

    public function edit(Plan $id)
    {
        $plan = Plan::find($id);
        // return new PlanResource($plan);

        return Inertia::render('Plan/Form', [
            'plan' => new PlanResource($id),
        ]);
    }

    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'price' => 'required',
            'sort_order' => 'required',
            'stripe_id' => 'required',
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $plan = Plan::find($id);

        if (
            $plan = Plan::where(['id' => $plan->id])->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'status' => $request->status,
                'price' => $request->price,
                'sort_order' => $request->sort_order,
                'stripe_id' => $request->stripe_id,
                'currency' => $request->currency,
            ])
        ) {
            return response()->json([
                'success' => true,
                'message' => 'Plan updated successfull',
                'redirect' => '/plan',
            ]);
            // return redirect('/plan')->with(['message' => 'Conversion Rate Updated successfully']);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong !',
                'redirect' => '/plan',
            ]);
        }
    }

    public function destroy(Plan $plan)
    {
        $plan = Plan::find($plan);
        if ($plan->delete()) {
            return response()->json(['success' => true, 'message' => 'Plan has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
