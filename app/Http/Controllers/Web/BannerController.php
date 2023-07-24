<?php

namespace App\Http\Controllers\Web;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Resources\Web\BannerResource;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = new Banner();
        if (!empty($request->q)) {
            $banners = $banners->where('title', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%");
        }
        if (!empty($request->s) || $request->s != '') {
            $banners = $banners->where('status', $request->s);
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $banner = Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
            'image_id' => $request->banner_image,
            'status' => 1,
        ]);
        if ($banner) {
            return redirect('banners')->with('flash', [
                'success' => true,
                'message' => CreateMessage('Banner'),
            ]);
        } else {
            return redirect('banners')->with('flash', [
                'success' => false,
                'message' => ErrorMessage(),
            ]);
        }
    }
    public function edit(banner $banner, $id)
    {
        $banner = Banner::find($id);
        return Inertia::render('Banner/Form', [
            'banner' => new BannerResource($banner)
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required',
            'url' => 'required|url',
            'banner_image' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $banner = Banner::find($id);
        if ($banner) {
            $banner = Banner::where(['id' => $banner->id])->update([
                'title' => $request->title,
                'description' => $request->description,
                'url' => $request->url,
                'image_id' =>  $request->banner_image,
            ]);
            return redirect('banners')->with('flash', [
                'success' => true,
                'message' => UpdateMessage('Banner'),
            ]);
        }
        return redirect('banners')->with('flash', [
            'success' => false,
            'message' => ErrorMessage(),
        ]);
    }

    public function statusUdate(Request $request)
    {

        if (Banner::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Banner', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner = new BannerResource($banner);

        if ($banner->delete()) {
            return response()->json(['success' => true, 'message' =>    DeleteMessage('Banner')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}