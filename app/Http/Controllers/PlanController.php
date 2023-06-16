<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Plan;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = new Plan();
        if (!empty($request->q)) {
            $plans = $plans
                ->where('name', 'like', "%$request->q")
                ->orWhere('sort_description', 'like', "%$request->q%")
                ->orWhere('price', 'like', "%$request->q%")
                ->orWhere('stripe_plan', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $plans = $plans->where('is_active', '=', $request->status);
        }
        return Inertia::render('Plan/View', [
            'plans' => PlanResource::collection($plans->paginate(10)->appends($request->all())),
        ]);
    }
    public function statusUpdate(Request  $request)
    {


        $plan  = Plan::where('id', $request->id)->update([
            'is_active' => $request->status
        ]);
        if ($plan) {

            return response()->json([
                'success' => true,
                'message' => 'Status Update successfully',
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }

    public function create()
    {
        $currencies = Currency::get();
        return Inertia::render('Plan/Form', [
            'currencies' => CurrencyResource::collection($currencies),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:plans,name',
            'sort_description' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'sort_order' => 'required',
            'stripe_plan' => 'required',
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $toDate = Carbon::parse($request->start_date);
        $fromDate = Carbon::parse($request->end_date);

        $interval = $toDate->diffInDays($fromDate);

        $plan = Plan::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'sort_description' => $request->sort_description,
            'description' => json_encode($request->items),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'interval' => $interval,
            'is_active' => $request->status,
            'price' => $request->price,
            'sort_order' => $request->sort_order,
            'stripe_plan' => $request->stripe_plan,
            'currency_id' => $request->currency,
        ]);
        if ($plan) {
            return response()->json([
                'success' => true,
                'message' => 'Plan created Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Plan not created'
        ]);
    }

    public function edit(Plan $plan)
    {
        $currencies = Currency::get();

        return Inertia::render('Plan/Form', [
            'plan' => new PlanResource($plan),
            'currencies' => CurrencyResource::collection($currencies),
        ]);
    }
    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'sort_description' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'sort_order' => 'required|numeric',
            'stripe_plan' => 'required',
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }

        $toDate = Carbon::parse($request->start_date);
        $fromDate = Carbon::parse($request->end_date);

        $interval = $toDate->diffInDays($fromDate);

        $plan = Plan::where(['id' => $plan->id])->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_description' => $request->sort_description,
            'description' => json_encode($request->items),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'interval' => $interval,
            'is_active' => $request->status,
            'price' => $request->price,
            'sort_order' => $request->sort_order,
            'stripe_plan' => $request->stripe_plan,
            'currency_id' => $request->currency,
        ]);

        if ($plan) {
            return redirect('/plan')->with('flash', [
                'success' => true,
                'message' => 'Plan updated Successfully',
            ]);
        }
        return redirect('/plan')->with('flash', [
            'success' => false,
            'message', 'Plan not updated',
        ]);
    }

    public function destroy(Plan $plan)
    {
        if ($plan->delete()) {
            return response()->json(['success' => true, 'message' => 'Plan has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $plan = Plan::whereIn('id', $request->ids)->delete();

        if ($plan) {
            return response()->json(['success' => true, 'message' => 'Plan has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function show()
    {
        return Inertia::render('Plan/Page/Success');
    }

    public function errorPage()
    {

        return Inertia::render('Plan/Page/Error');
    }
}
