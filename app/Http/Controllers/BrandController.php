<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\Image as CategoryImage;
use App\Http\Resources\BrandResource;
use Illuminate\Support\Str;


class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = new Brand();
        if($request->q){
            $brands = $brands->where('name','like',"%{$request->q}%");
        }
        $brands = $brands->paginate(10)->onEachSide(1)->appends(request()->query());
        $brands = BrandResource::collection($brands);
        // return $brands;
        return view('pages.brand.index' ,compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        // return $categories;
        return view('pages.brand.add' , [ 'categories' => $categories ]);
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
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first()
                    ],400);
        }
        // dd($request);
        $bran = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category,
            'status' =>$request->status,
            'image_id' =>$request->brand_image,
        ]);

        return response()->json(['success'=>true,'message'=>'Brand created successfully']);
    }


    public function show($id)
    {
        $brand = Brand::find($id);
        $brand = new BrandResource($brand);

        // return $brand;
        return view('pages.brand.view' , [ 'brand' => $brand ] );
    }

    public function edit( $id)
    {
        $categories = Category::get();
        $brand = Brand::find($id);
        $brand =new BrandResource($brand);
        // return $brand;
        return view('pages.brand.edit' , [ 'brand' => $brand,'categories'=>$categories ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'brand_image' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()->all()
                    ]);
        }

        $brand = Brand::find($id);
        if($brand){
            $brand = Brand::where(['id'=>$id])->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category_id' => $request->category,
            'status' =>$request->status,
            'image_id' =>$request->brand_image,
            ]);

            return response()->json(['success'=>true,'message'=>'Brand Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand =new BrandResource($brand);
        // dd($category->image);
        if($brand->delete()){
            return response()->json(['success'=>true,'message'=>'Brand has been deleted successfully.']);
        }
        return response()->json(['success'=>false,'message'=>'Opps something went wrong!'],400);
    }
}
