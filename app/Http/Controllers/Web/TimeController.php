<?php

namespace App\Http\Controllers\Web;


use App\Models\Time;
use App\Http\Resources\Web\TimeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $times = new Time();
        if (!empty($request->q)) {
            $times = $times->where('title', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%");
        }
        if (!empty($request->s) || $request->s != '') {
            $times = $times->where('status', $request->s);
        }
        return Inertia::render('Times/Index', [
            'times' => TimeResource::collection($times->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function statusUdate(Request $request)
    {
        if (Time::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Time', $status), 'success' => true]);
        }
        return response()->json(['message' => ErrorMessage(), 'success' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Times/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'unique:' . Time::class],
            'status' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $time = Time::create([
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
        ]);
        if ($time) {
            return redirect()->route('times.index')->with('flash', ['success' => true, 'message' => CreateMessage('Notification Type')]);
        }
        return redirect()->route('times.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function edit($id)
    {
        return Inertia::render('Times/Form', [
            'time' => new TimeResource(Time::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => ['required', Rule::unique('times')->ignore($id),],
            'status' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $time = Time::find($id);

        if ($time) {
            $time = Time::where(['id' => $id])->update([
                'title' => $request->title,
                'status' => $request->status,
                'description' => $request->description,
            ]);
            return redirect()->route('times.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Time')]);
        }

        return "sdasd";
        return redirect()->back()->withErrors(['success' => false, 'message' => "sdasd" . ErrorMessage()]);
    }


    public function destroy(Time $time, $id)
    {
        $time = Time::find($id);
        if ($time->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Time')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
