<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $plans = new Plan();
        // if ($request->q) {
        //     $plans = $plans->where('name', 'like', "%{$request->q}%");
        // }
        // $plans = $plans->paginate(10)->onEachSide(1)->appends(request()->query());
        // $plans = PlanResource::collection($plans);
        // // return $plans;
        // return view('pages.plan.index', compact('plans'));
        return view('pages.plan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $segments = $request->segments();

        $category = Category::get();
        return view('pages.plan.add', ['category' => $category , 'segments' =>$segments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:'.Plan::class],
            'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'category' => 'required',
            'no_of_ads' => 'required|integer',
            'currency' => 'required|integer',
            'sign_up_fee' => 'required|integer',
            'trial_period' => 'required|integer',
            'trial_interval' => 'required',
            'invoice_period' => 'required|integer',
            'invoice_interval' => 'required',
            'grace_period' => 'required|integer',
            'grace_interval' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required|integer',
            'sort_description' => 'required',
            'prorate_day' => 'nullable|integer',
            'prorate_period' => 'nullable|integer',
            'prorate_extend_due' => 'nullable|integer',
            'active_subscribers_limit' => 'nullable|integer',
        ]);

        // return $request->plan_conditions;

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }
        $plan = Plan::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category,
            'no_of_ads' => $request->no_of_ads,
            'currency' => $request->currency,
            'signup_fee' => $request->sign_up_fee,
            'trial_period' => $request->trial_period,
            'trial_interval' => $request->trial_interval,
            'invoice_period' => $request->invoice_period,
            'invoice_interval' => $request->invoice_interval,
            'grace_period' => $request->grace_period,
            'grace_interval' => $request->grace_interval,
            'prorate_day' => $request->prorate_day,
            'prorate_period' => $request->prorate_period,
            'prorate_extend_due' => $request->prorate_extend_due,
            'active_subscribers_limit' => $request->active_subscribers_limit,
            'sort_order' => $request->sort_order,
            'is_active' => $request->status,
            'sort_description' => $request->sort_description,
            'description' => json_encode($request->plan_conditions),
        ]);

        return response()->json(['success' => true, 'message' => 'Plan created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Plan $plan, $id)
    {
        $segments = $request->segments();

        $category = Category::get();
        $plan = Plan::find($id);
        $plan = new PlanResource($plan);
        // return $category;
        return view('pages.plan.edit', ['plan' => $plan, 'category' => $category ,'segments' => $segments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'category' => 'required',
            'no_of_ads' => 'required|integer',
            'currency' => 'required|integer',
            'sign_up_fee' => 'required|integer',
            'trial_period' => 'required|integer',
            'trial_interval' => 'required',
            'invoice_period' => 'required|integer',
            'invoice_interval' => 'required',
            'grace_period' => 'required|integer',
            'grace_interval' => 'required',
            'sort_order' => 'required|integer',
            'status' => 'required|integer',
            'sort_description' => 'required',
            'prorate_day' => 'nullable|integer',
            'prorate_period' => 'nullable|integer',
            'prorate_extend_due' => 'nullable|integer',
            'active_subscribers_limit' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $plan = Plan::find($id);
        if ($plan) {
            $plan = Plan::where(['id' => $id])->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category,
                'no_of_ads' => $request->no_of_ads,
                'currency' => $request->currency,
                'signup_fee' => $request->sign_up_fee,
                'trial_period' => $request->trial_period,
                'trial_interval' => $request->trial_interval,
                'invoice_period' => $request->invoice_period,
                'invoice_interval' => $request->invoice_interval,
                'grace_period' => $request->grace_period,
                'grace_interval' => $request->grace_interval,
                'prorate_day' => $request->prorate_day,
                'prorate_period' => $request->prorate_period,
                'prorate_extend_due' => $request->prorate_extend_due,
                'active_subscribers_limit' => $request->active_subscribers_limit,
                'sort_order' => $request->sort_order,
                'is_active' => $request->status,
                'sort_description' => $request->sort_description,
                'description' => json_encode($request->plan_conditions),
            ]);

            return response()->json(['success' => true, 'message' => 'Plan Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan, $id)
    {
        $plan = Plan::find($id);
        $plan = new PlanResource($plan);
        if ($plan->delete()) {
            return response()->json(['success' => true, 'message' => 'Plan has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
