<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Industry;
use Illuminate\Http\Request;
use App\Models\DecisionMaker;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DecisionMakerResources;

class DecisionMakerController extends Controller
{
    public function index(Request $request)
    {
        $decisionmakers = new DecisionMaker();

        if (!empty($request->q)) {
            $decisionmakers = $decisionmakers
                ->whereHas('industry', function ($q) use ($request) {
                    $q->where('name', 'like', "%$request->q%");
                })
                ->orWhere('title', 'like', "%$request->q%");
        }

        return Inertia::render('DecisionMakers/Index', [
            'decisionmakers' => DecisionMakerResources::collection($decisionmakers->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        $industries = Industry::get();
        return Inertia::render('DecisionMakers/Form', ['industries' => $industries]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'order_by' => 'required',
            'industry' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }
        $decisionmaker = DecisionMaker::create([
            'title' => $request->title,
            'industry_id' => $request->industry,
            'order_by' => $request->order_by,
        ]);
        if ($decisionmaker) {
            return response()->json(['success' => true, 'message' => 'DecisionMaker created successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'DecisionMaker not created']);
        }
    }

    public function edit($id)
    {
        $industries = Industry::get();

        $decisionmaker = DecisionMaker::find($id);

        // $DecisionMaker = new DecisionMakerResources($DecisionMaker);

        return Inertia::render('DecisionMakers/Form', [
            'decisionmaker' => new DecisionMakerResources($decisionmaker),
            'industries' => $industries,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'order_by' => 'required',
            'industry' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }
        $decisionmaker = DecisionMaker::find($id);


        $decisionmaker = DecisionMaker::where(['id' => $decisionmaker->id])->update([
            'title' => $request->title,
            'industry_id' => $request->industry,
            'order_by' => $request->order_by,
        ]);
        if ($decisionmaker) {
            return response()->json(['success' => true, 'message' => 'DecisionMaker updated successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'DecisionMaker not updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DecisionMaker  $DecisionMaker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decisionmaker = DecisionMaker::find($id);
        if ($decisionmaker->delete()) {
            return response()->json(['success' => true, 'message' => 'Decision Maker has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $decisionmaker = DecisionMaker::whereIn('id', $request->ids)->delete();

        if ($decisionmaker) {
            return response()->json(['success' => true, 'message' => 'Decision Maker has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
