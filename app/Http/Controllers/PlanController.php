<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Plan;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use App\Http\Resources\TimeResource;
use App\Models\Currency;
use App\Models\Time;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Razorpay\Api\Api;

class PlanController extends Controller
{
    private $api;
    function __construct()
    {
        $this->api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    }
    public function index(Request $request)
    {
        $plans = new Plan();
        if (!empty($request->q)) {
            $plans = $plans->where('name', 'like', "%{$request->q}%")
                ->orWhere('sort_description', 'like', "%{$request->q}%")
                ->orWhere('price', 'like', "%{$request->q}%")
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->q}%");
                });
        }

        if (!empty($request->s) || $request->s != '') {
            $plans = $plans->where('status', $request->s);
        }
        return Inertia::render('Plan/Index', [
            'plans' => PlanResource::collection($plans->paginate(10)->onEachSide(1)->appends(request()->query())),
        ]);
    }

    public function statusUdate(Request $request)
    {
        if (Plan::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Plan', $status), 'success' => true]);
        }
        return response()->json(['message' => ErrorMessage(), 'success' => false]);
    }
    public function create()
    {
        return Inertia::render('Plan/Form', [
            'times' =>  TimeResource::collection(Time::get()),
            'currencies' => CurrencyResource::collection(Currency::get()),
            'categories' => CategoryResource::collection(Category::get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:' . Plan::class],
            'price' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'category' => 'required',
            'no_of_ads' => 'required|integer',
            'currency' => 'required',
            'status' => 'required|integer',
            'sort_description' => '',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }


        $response = $this->api->plan->create(
            array(
                'period' => $request->period, 'interval' => 1,
                'item' => array('name' => $request->name, 'description' => $request->short_description, 'amount' => $request->price, 'currency' => $request->currency)
            )
        );

        $plan = Plan::create([
            'name' => $request->name,
            'period' => $request->period,
            'price' => $request->price,
            'plan_id' => $response->id,
            'category_id' => $request->category,
            'no_of_ads' => $request->no_of_ads,
            'currency' => $request->currency,
            'sort_order' => $request->sort_order,
            'status' => $request->status,
            'sort_description' => $request->sort_description,
            'description' => json_encode($request->plan_descriptions),
        ]);


        if ($plan) {
            return redirect()->route('plans.index')->with('flash', ['success' => true, 'message' => CreateMessage('Plan')]);
        } else {
            return redirect()->route('plans.index')->with('flash', ['success' => false, 'message' => ErrorMessage('Plan')]);
        }
    }


    public function edit($id)
    {
        return Inertia::render('Plan/Form', [
            'times' =>  TimeResource::collection(Time::get()),
            'currencies' => CurrencyResource::collection(Currency::get()),
            'categories' => CategoryResource::collection(Category::get()),
            'plan' => new PlanResource(Plan::find($id)),
        ]);
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
            'currency' => 'required',
            'status' => 'required|integer',
            'sort_description' => '',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $response = $this->api->plan->create(
            array(
                'period' => $request->period, 'interval' => 1,
                'item' => array('name' => $request->name, 'description' => $request->short_description, 'amount' => $request->price, 'currency' => $request->currency)
            )
        );

        $plan = Plan::find($id);
        if ($plan) {
            $plan = Plan::where(['id' => $id])->update([
                'name' => $request->name,
                'period' => $request->period,
                'price' => $request->price,
                'plan_id' => $response->id,
                'category_id' => $request->category,
                'no_of_ads' => $request->no_of_ads,
                'currency' => $request->currency,
                'sort_order' => $request->sort_order,
                'status' => $request->status,
                'sort_description' => $request->sort_description,
                'description' => json_encode($request->plan_descriptions),
            ]);

            if ($plan) {
                return redirect()->route('plans.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Plan')]);
            } else {
                return redirect()->route('plans.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
            }
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
