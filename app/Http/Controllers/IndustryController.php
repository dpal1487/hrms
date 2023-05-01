<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Http\Resources\IndustryResource;
use Image;
use App\Models\Image as DBImage;
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
        $request->validate([
            'name' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        if (
            $industry = Industry::create([
                'name' => $request->name,
                'image_id' => $request->image_id,
                'status' => $request->status,
            ])
        ) {
            return redirect()
                ->route('industries.index')
                ->with('message', 'Industries created Successfully');
        }
    }

    public function show(Industry $industry)
    {
        //
    }

    public function edit(Industry $industry, $id)
    {
        $industry = Industry::find($id);

        // return new IndustryResource($industry);

        return Inertia::render('Industry/Form', [
            'industry' => new IndustryResource($industry),
        ]);
    }

  
    public function update(Request $request, Industry $industry, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);
        $industry = Industry::find($id);
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
        return redirect()
            ->route('industries.index')
            ->with('message', 'Industries updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Industry $industry, $id)
    {
        $industry = Industry::find($id);
        if ($industry->delete()) {
            return response()->json(['success' => true, 'message' => 'Industry has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
