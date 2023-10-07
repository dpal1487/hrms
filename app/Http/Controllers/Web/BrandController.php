<?php

namespace App\Http\Controllers\Web;


use App\Http\Resources\Web\BrandListResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Web\BrandResource;
use App\Http\Resources\Web\Category\CategoryListResource;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = new Brand();
        if (!empty($request->q)) {
            $brands = $brands->where('name', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$request->q}%")->orWhereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%");
            });
        }
        if (!empty($request->s) || ($request->s != '')) {
            $brands = $brands->where('status', $request->s);
        }

        $brands = $brands->orderBy('created_at', 'desc');
        // return $brands;
        return Inertia::render('Brands/Index', [
            'brands' => BrandListResource::collection($brands->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function statusUdate(Request $request)
    {

        if (Brand::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Brand', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Brands/Form', [
            'categories' => CategoryListResource::collection(Category::get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'brand_image' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'status' => $request->status,
            'image_id' => $request->brand_image,
        ]);

        if ($brand) {
            return redirect('brands')->with('flash', [
                'success' => true,
                'message' => CreateMessage('Brand')
            ]);
        }
        return redirect('brands')->with('flash', [
            'success' => false,
            'message' => ErrorMessage()
        ]);
    }


    public function show($id)
    {
        return Inertia::render('Brands/Show', [
            'brand' => new BrandResource(Brand::find($id)),
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Brands/Form', [
            'categories' => CategoryListResource::collection(Category::get()),
            'brand' => new BrandListResource(Brand::find($id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $brand = Brand::find($id);
        if ($brand) {
            if ($request->brand_image != '') {
                $brand = Brand::where(['id' => $id])->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'status' => $request->status,
                    'image_id' => $request->brand_image,
                ]);
            } else {
                $brand = Brand::where(['id' => $id])->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'description' => $request->description,
                    'category_id' => $request->category,
                    'status' => $request->status,
                    'image_id' => $brand->image_id,
                ]);
            }

            if ($brand) {
                return redirect('brands')->with('flash', [
                    'success' => true,
                    'message' => UpdateMessage('Brand')
                ]);
            }
            return redirect('brands')->with('flash', [
                'success' => false,
                'message' => ErrorMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if ($brand->delete()) {
            return response()->json(['success' => true, 'message' => 'Brand has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
