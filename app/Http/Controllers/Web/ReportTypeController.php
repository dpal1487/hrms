<?php

namespace App\Http\Controllers;

use App\Models\ReportType;
use Illuminate\Http\Request;
use App\Http\Resources\ReportTypeResource;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ReportTypeController extends Controller
{
    public function index(Request $request)
    {
        $reporttypes = new ReportType();
        if (!empty($request->q)) {
            $reporttypes = $reporttypes->where('title', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%");
        }
        return Inertia::render('ReportTypes/Index', [
            'reporttypes' => ReportTypeResource::collection($reporttypes->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function create()
    {
        return Inertia::render('ReportTypes/Form');
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

            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }
        $reporttype = ReportType::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($reporttype) {
            return redirect()->route('report-types.index')->with('flash', ['success' => true, 'message' => CreateMessage('Report Type')]);
        }
        return redirect()->route('report-types.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }


    public function edit($id)
    {
        return Inertia::render('ReportTypes/Form', [
            'report_type' => new ReportTypeResource(ReportType::find($id))
        ]);
    }

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

            return redirect()->route('report-types.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Report Type')]);
        }
        return redirect()->route('report-types.index')->with('flash', ['success' => true, 'message' => ErrorMessage()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reporttype = ReportType::find($id);
        $reporttype = new ReportTypeResource($reporttype);
        if ($reporttype->delete()) {
            return response()->json(['success' => true, 'message' => 'Report Type has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
