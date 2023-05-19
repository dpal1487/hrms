<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Http\Resources\IndustryResource;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia;

use Illuminate\Http\Request;

class IndustryController extends Controller
{

    public function index(Request $request)
    {
        $industries = new Industry();
        if (!empty($request->q)) {
            $industries = $industries->where('name', 'like', '%' . $request->q . '%');
        }

        if (!empty($request->status) || $request->status != '') {
            $industries = $industries->where('status', '=', $request->status);
        }
        return Inertia::render('Industry/Index', [
            'industries' => IndustryResource::collection($industries->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('Industry/Form');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $industry = Industry::create([
            'name' => $request->name,
            'image_id' => $request->image_id,
            'status' => $request->status,
        ]);
        if ($industry) {
            return response()->json([
                'success' => true,
                'message' => 'Industries created successfully',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Industries not crated',
        ], 200);
    }

    public function show(Industry $industry)
    {
        //
    }

    public function edit(Industry $industry)
    {

        return Inertia::render('Industry/Form', [
            'industry' => new IndustryResource($industry),
        ]);
    }


    public function update(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $industry = new IndustryResource($industry);


        if ($request->image_id) {
            $industry = Industry::where(['id' => $industry->id])->update([
                'name' => $request->name,
                'image_id' => $request->image_id,
                'status' => $request->status,
            ]);
        } else {
            $industry = Industry::where(['id' => $industry->id])->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
        }

        if ($industry) {
            return response()->json([
                'success' => true,
                'message' => 'Industries updated successfully',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => 'Industries not updated',
        ], 400);
    }

    public function destroy(Industry $industry)
    {

        if ($industry->delete()) {
            return response()->json(['success' => true, 'message' => 'Industry has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
