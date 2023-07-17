<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\TimePeriod;
use App\Models\Category;
use App\Models\Time;
use DB;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimePeriodResource;
use App\Http\Resources\TimeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimePeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $timePeriods = new Category();
        if ($request->q) {
            $timePeriods = $timePeriods->where('name', 'like', "%{$request->q}%");
        }
        $categories = Category::paginate(10)->onEachSide(1);
        return Inertia::render('TimePeriods/Index', [
            'timeperiods' => CategoryResource::collection($categories),
        ]);
    }

    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //         return response()->json(['message' => "Your Status has been " . $status, 'success' => true]);
    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryResource(Category::find($id)),
            'times' => TimeResource::collection(Time::get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'timePeriods.*.time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        foreach ($request->timePeriods as $key => $value) {
            $timePeriods =    TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['time'],
            ]);
        }
        if ($timePeriods) {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => CreateMessage('Time Period')]);
        }

        return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryResource(Category::find($id)),
            'times' => TimeResource::collection(Time::get()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $segments = $request->segments();
        $category = Category::find($id);
        $times = Time::get();
        $timePeriod = TimePeriod::where('category_id', '=', $id)->get();

        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryResource($category),
            'times' => TimeResource::collection($times),
            'timePeriods' => TimePeriodResource::collection($timePeriod),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimePeriod $timePeriod, $id)
    {


        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'timePeriods.*.time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $timeCategory = TimePeriod::where('category_id', $id)->delete();
        foreach ($request->timePeriods as $key => $value) {
            $timePeriods =    TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['time'],
            ]);
        }
        if ($timePeriods) {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => CreateMessage('Time Period')]);
        }

        return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimePeriod $timePeriod, $id)
    {

        $attribute = TimePeriod::where('category_id', '=', $id);
        if ($attribute->delete()) {
            return response()->json(['success' => true, 'message' => 'Time Period has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
