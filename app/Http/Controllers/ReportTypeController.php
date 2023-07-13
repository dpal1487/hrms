<?php

namespace App\Http\Controllers;

use App\Models\ReportType;
use Illuminate\Http\Request;
use App\Http\Resources\ReportTypeResource;
use Illuminate\Support\Facades\Validator;

class ReportTypeController extends Controller
{
    public function index(Request $request)
    {
        $reporttypes = new ReportType();
        if ($request->q) {
            $reporttypes = $reporttypes->where('title', 'like', "%{$request->q}%");
        }
        $reporttypes = $reporttypes->paginate(10)->onEachSide(1)->appends(request()->query());
        $reporttypes = ReportTypeResource::collection($reporttypes);
        return view('pages.report-type.index', compact('reporttypes'));
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
    public function create()
    {
        return view('pages.report-type.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
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

        $reporttype = ReportType::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Report Type created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reporttype = ReportType::find($id);
        $reporttype = new ReportTypeResource($reporttype);
        return view('pages.report-type.edit', ['reporttype' => $reporttype]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $reporttype = ReportType::find($id);
        if ($reporttype) {
            $reporttype = ReportType::where(['id' => $id])->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Report Type Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $reporttype = ReportType::find($id);
        $reporttype = new ReportTypeResource($reporttype);
        if ($reporttype->delete()) {
            return response()->json(['success' => true, 'message' => 'Report Type has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
