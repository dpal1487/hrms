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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $industries = new Industry();
    if (!empty($request->q)) {
        $industries = $industries->where('name', 'like', '%'.$request->q.'%');
    }

    if (!empty($request->status))  {
        $industries = $industries->where('status','=', $request->status);
    }

        return Inertia::render('Industry/Index', [
            'industries' => IndustryResource::collection($industries->paginate(10)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Industry/Form');
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
            'name' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg',
            'status' => 'required',
        ]);

        $image = $request->file('image');

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/industry/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/industry/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/industry/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);

            // dd($Imagefile);
        }

        if (
            $industry = Industry::create([
                'name' => $request->name,
                'image_id' => $Imagefile->id,
                'status' => $request->status,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'Employee created successfully']);
            return redirect()
                ->route('industries.index')
                ->with('message', 'Industries created Successfully');
            // return redirect('/industries');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function show(Industry $industry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function edit(Industry $industry, $id)
    {
        $industry = Industry::find($id);

        // return new IndustryResource($industry);

        return Inertia::render('Industry/Form', [
            'industry' => new IndustryResource($industry),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Industry  $industry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Industry $industry, $id)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        $industry = Industry::find($id);

        $industry = new IndustryResource($industry);

        $image = $request->file('image');

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/industry/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/industry/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/industry/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);

            // dd($Imagefile);
        }

        if ($image) {
            $industry = Industry::where(['id' => $industry->id])->update([
                'name' => $request->name,
                'image_id' => $Imagefile->id,
                'status' => $request->status,
            ]);
        } else {
            $industry = Industry::where(['id' => $industry->id])->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
        }

        // return response()->json(['success' => true, 'message' => 'Employee created successfully']);

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
