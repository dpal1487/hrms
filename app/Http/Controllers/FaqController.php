<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use App\Models\Image as CategoryImage;
use App\Http\Resources\FAQsResource;
use Illuminate\Support\Str;
class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $faqs = new Faq();
        if($request->q){
            $faqs = $faqs->where('title','like',"%{$request->q}%");
        }
        $faqs = $faqs->paginate(10)->onEachSide(1)->appends(request()->query());
        $faqs = FAQsResource::collection($faqs);
        // return $faqs;
        return view('pages.faqs.index' ,compact('faqs'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'actical' => 'required',
            'faq_category' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first()
                    ],400);
        }
        // dd($request);
        $bran = Faq::create([
            'title' => $request->title,
            'artical' => $request->actical,
            'category_id' => $request->faq_category,
        ]);

        return response()->json(['success'=>true,'message'=>'FAQs created successfully']);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq , $id)
    {

        $faq = Faq::find($id);
        if($faq){
            return response()->json($faq);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq , $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'actical' => 'required',
            'faq_category' =>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()->all()
                    ]);
        }

        $faq = Faq::find($id);
        if($faq){
            $faq = Faq::where(['id'=>$id])->update([
                'title' => $request->title,
            'artical' => $request->actical,
            'category_id' => $request->faq_category,
            ]);

            return response()->json(['success'=>true,'message'=>'FAQs Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq ,$id)
    {
        $faq = Faq::find($id);
        // $brand =new BrandResource($brand);
        // dd($category->image);
        if($faq->delete()){
            return response()->json(['success'=>true,'message'=>'FAQs has been deleted successfully.']);
        }
        return response()->json(['success'=>false,'message'=>'Opps something went wrong!'],400);
    }
}
