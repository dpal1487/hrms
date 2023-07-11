<?php

namespace App\Http\Controllers;

use App\Models\TimePeriod;
use App\Models\Category;
use App\Models\Time;
use DB;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TimePeriodResource;

use Illuminate\Http\Request;

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
        return view('pages.time-period.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request ,$id)
    {
        $segments = $request->segments();
        $category = Category::find($id);
        $times = Time::get();
        return view('pages.time-period.add', ['category' => $category, 'times' => $times , 'segments' => $segments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'add_time_conditions.*.time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }

        foreach ($request->add_time_conditions as $key => $value) {
            TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['time'],
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Time Period created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(TimePeriod $timePeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request , $id)
    {
        $segments = $request->segments();
        $category = Category::find($id);
        $times = Time::get();
        $timePeriod = TimePeriod::where('category_id', '=', $id)->get();

        return view('pages.time-period.edit', ['timePeriod' => TimePeriodResource::collection($timePeriod), 'times' => $times, 'category' => $category , 'segments' => $segments]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimePeriod $timePeriod, $id)
    {
        $timeCategory = DB::table('time_periods')
            ->where('category_id', '=', $id)
            ->delete();

            $validator = Validator::make($request->all(), [
            'category' => 'required',
            'add_time_conditions.*.time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }

        foreach ($request->add_time_conditions as $key => $value) {
            TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['time'],
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Time Period Updated successfully']);
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
