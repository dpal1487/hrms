<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Http\Resources\TimeResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $times = new Time();
        if ($request->q) {
            $times = $times->where('title', 'like', "%{$request->q}%");
        }
        $times = $times->paginate(10)->onEachSide(1)->appends(request()->query());
        $times = TimeResource::collection($times);
        return view('pages.time.index', compact('times'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.time.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required','unique:'.Time::class],
            'status' => 'required',
            'description' => 'required',
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

        $time = Time::create([
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Time created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Time $time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Time $time, $id)
    {
        $time = Time::find($id);
        $time = new TimeResource($time);
        return view('pages.time.edit', ['time' => $time]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Time $time, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $time = Time::find($id);
        if ($time) {
            $time = Time::where(['id' => $id])->update([
                'title' => $request->title,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Time Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Time $time , $id)
    {
        $time = Time::find($id);
        $time = new TimeResource($time);
        if ($time->delete()) {
            return response()->json(['success' => true, 'message' => 'Time has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
