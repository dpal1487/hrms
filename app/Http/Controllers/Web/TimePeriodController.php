<?php

namespace App\Http\Controllers\Web;


use App\Http\Resources\Web\Category\CategoryListResource;
use App\Models\TimePeriod;
use App\Models\Category;
use App\Models\Time;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Web\TimeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TimePeriodController extends Controller
{
    public function index(Request $request)
    {
        $categories = new Category();
        if ($request->q) {
            $categories = $categories->where('name', 'like', "%{$request->q}%");
        }
        return Inertia::render('TimePeriods/Index', [
            'times' => TimeResource::collection(Time::get()),
            'categories' => CategoryListResource::collection($categories->paginate(10)->onEachSide(1)->appends(request()->query())),
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time_periods' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['success' => false, 'message' => $validator->errors()->first(),]);
        }

        $timePeriods =  TimePeriod::where('category_id', $request->category)->get();
        if ($timePeriods) {
            TimePeriod::where('category_id', $request->category)->delete();
        }
        foreach ($request->time_periods as $key => $value) {
            $timePeriod = TimePeriod::create([
                'category_id' => $request->category,
                'time_id' => $value,
            ]);
        }
        if ($timePeriod) {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => CreateMessage('Time Period')]);
        } else {
            return redirect()->route('time-periods.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
        }
    }
}
