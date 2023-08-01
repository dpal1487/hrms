<?php

namespace App\Http\Controllers\Web;


use App\Http\Resources\Web\CategoryListResource;
use App\Models\TimePeriod;
use App\Models\Category;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Web\TimePeriodResource;
use App\Http\Resources\Web\TimeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimePeriodController extends Controller
{
    public function index(Request $request)
    {
        $timePeriods = new Category();
        if ($request->q) {
            $timePeriods = $timePeriods->where('name', 'like', "%{$request->q}%");
        }
        $categories = Category::paginate(10)->onEachSide(1);
        return Inertia::render('TimePeriods/Index', [
            'timeperiods' => CategoryListResource::collection($categories),
        ]);
    }
    public function create($id)
    {
        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryListResource(Category::find($id)),
            'times' => TimeResource::collection(Time::get()),
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'time_periods.*.id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        foreach ($request->time_periods as $key => $value) {
            $time_periods =    TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['id'],
            ]);
        }
        if ($time_periods) {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => CreateMessage('Time Period')]);
        } else {

            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
        }
    }
    public function show($id)
    {
        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryListResource(Category::find($id)),
            'times' => TimeResource::collection(Time::get()),
        ]);
    }
    public function edit(Request $request, $id)
    {
        $category = Category::find($id);
        $times = Time::get();
        $timePeriod = TimePeriod::where('category_id', '=', $id)->get();
        return Inertia::render('TimePeriods/Form', [
            'category' => new CategoryListResource($category),
            'times' => TimeResource::collection($times),
            'timePeriods' => TimePeriodResource::collection($timePeriod),
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'time_periods.*.id' => 'required',
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
        foreach ($request->time_periods as $key => $value) {
            $time_period =    TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value['id'],
            ]);
        }
        if ($time_period != null) {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Time Period')]);
        }
        return redirect()->route('time-periods.index')->withErrors(['success' => false, 'message' => ErrorMessage()]);
    }
    public function destroy($id)
    {
        $attribute = TimePeriod::where('category_id', '=', $id);
        if ($attribute->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Time Period')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
