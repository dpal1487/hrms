<?php

namespace App\Http\Controllers;

use App\Http\Resources\CorporationTypeResource;
use App\Models\CorporationType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CorporationTypeController extends Controller
{
    public function index(Request $request)
    {
        $corporationtypes = new CorporationType();
        if (!empty($request->q)) {

            $corporationtypes = $corporationtypes
                ->where('title', 'like', "%$request->q")
                ->orWhere('description', 'like', "%$request->q%");
        }
        return Inertia::render('CorporationType/Index', [
            'corporationtypes' => CorporationTypeResource::collection($corporationtypes->paginate(10)->appends($request->all())),
        ]);
    }
    public function create()
    {
        return Inertia::render('CorporationType/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required',
            'description' => 'required',
        ]);

        $corporationtype = CorporationType::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($corporationtype) {
            return response()->json([
                'success' => true,
                'message' => 'Corporation Type created successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Corporation Type not created',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CorporationType  $corporationType
     * @return \Illuminate\Http\Response
     */
    public function show(CorporationType $corporationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CorporationType  $corporationType
     * @return \Illuminate\Http\Response
     */
    public function edit(CorporationType $corporationType)
    {
        // $corporationtype = corporationtype::find($id);
        return Inertia::render('CorporationType/Form', [
            'corporationtype' => new CorporationTypeResource($corporationType),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CorporationType  $corporationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CorporationType $corporationType)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // $corporationtype = corporationtype::find($id);


        $corporationtype = corporationtype::where(['id' => $corporationType->id])->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($corporationtype) {
            return response()->json([
                'success' => true,
                'message' => 'Corporation Type updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Corporation Type not updated',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CorporationType  $corporationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CorporationType $corporationType)
    {
        // $corporationtype = corporationtype::find($id);
        if ($corporationType->delete()) {
            return response()->json(['success' => true, 'message' => 'Corporation Type has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $corporationtype = CorporationType::whereIn('id', $request->ids)->delete();

        if ($corporationtype) {
            return response()->json(['success' => true, 'message' => 'Corporation Type has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
