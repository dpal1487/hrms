<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry;
use App\Models\DecisionMaker;
use App\Http\Resources\DecisionMakerResources;
use Inertia\Inertia;

class DecisionMakerController extends Controller
{
    public function index(Request $request)
    {
        $decisionmakers = DecisionMaker::get();

        // return DecisionMakerResources::collection($decisionmakers);?

        // return $DecisionMakers;
        // $decisionmakers = new DecisionMaker();

        // if (!empty($request->q)) {
        //     $decisionmakers = $decisionmakers
        //         ->whereHas('industry', function ($q) use ($request) {
        //             $q->where('name', 'like', "%$request->q%");
        //         })
        //         ->orWhere('title', 'like', "%$request->q%");
        // }

        // return DecisionMakerResources::collection($decisionmakers);
        return Inertia::render('DecisionMakers/Index', [
            'decisionmakers' => DecisionMakerResources::collection($decisionmakers),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industries = Industry::get();
        // return $industries;
        return Inertia::render('DecisionMakers/Form', ['industries' => $industries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'title' => 'required',
            'order_by' => 'required',
            'industry' => 'required',
        ]);

        if (
            $decisionmaker = DecisionMaker::create([
                'title' => $request->title,
                'industry_id' => $request->industry,
                'order_by' => $request->order_by,
            ])
        ) {
            return response()->json(['success' => true, 'message' => 'DecisionMaker created successfully']);

            // return redirect('/decisionmaker');
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
        $request->validate([
            'title' => 'required',
            'order_by' => 'required',
            'industry' => 'required',
        ]);

        $decisionmaker = DecisionMaker::find($id);

        if (
            $decisionmaker = DecisionMaker::where(['id' => $decisionmaker->id])->update([
                'title' => $request->title,
                'industry_id' => $request->industry,
                'order_by' => $request->order_by,
            ])
        ) {
            return response()->json(['success' => true, 'message' => 'DecisionMaker Updated successfully']);

            // return redirect('/decision-makers');
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
}
