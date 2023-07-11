<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $banners = new Banner();
        if ($request->q) {
            $banners = $banners->where('title', 'like', "%{$request->q}%");
        }

        return Inertia::render('Banner/Index', [
            'banners' => BannerResource::collection($banners->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function create()
    {
        return Inertia::render('Banner/Form');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required',
            'url' => 'required|url',
            'banner_image' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $banner = Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image_id' => $request->banner_image,
            'status' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Banner created successfully']);
    }

    public function show(banner $banner)
    {
    }

    public function edit(banner $banner, $id)
    {
        $banner = Banner::find($id);
        $banner = new BannerResource($banner);

        return view('pages.banner.edit', ['banner' => $banner]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required',
            'url' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $banner = Banner::find($id);
        if ($banner) {
            $banner = Banner::where(['id' => $banner->id])->update([
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,

            ]);
            return response()->json(['success' => true, 'message' => 'Banner Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner = new BannerResource($banner);

        if ($banner->delete()) {
            return response()->json(['success' => true, 'message' => 'Banner has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
