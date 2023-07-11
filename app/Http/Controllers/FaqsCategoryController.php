<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FAQsCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Image as CategoryImage;
use App\Http\Resources\FAQsResource;
use Illuminate\Support\Str;

class FaqsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs = new FAQsCategory();
        if ($request->q) {
            $faqs = $faqs->where('title', 'like', "%{$request->q}%");
        }
        $faqs = $faqs->paginate(10)->onEachSide(1)->appends(request()->query());
        $faqs = FAQsResource::collection($faqs);
        return view('pages.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return $categories;
        return view('pages.faqs.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'faq_image' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
                400,
            );
        }
        // dd($request);
        $faq = FAQsCategory::create([
            'title' => $request->title,
            'status' => $request->status,
            'image_id' => $request->faq_image,
        ]);

        return response()->json(['success' => true, 'message' => 'FAQs Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQsCategory $fAQsCategory , $id)
    {
        $faq = FAQsCategory::find($id);
        $faq = new FAQsResource($faq);
        return view('pages.faqs.view', ['faq' => $faq]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQsCategory $fAQsCategory, $id)
    {
        $categories = Category::get();
        $faq = FAQsCategory::find($id);
        $faq = new FAQsResource($faq);
        return view('pages.faqs.edit', ['faq' => $faq, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQsCategory $fAQsCategory, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'faq_image' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }

        $faq = FAQsCategory::find($id);
        if ($faq) {
            $faq = FAQsCategory::where(['id' => $id])->update([
                'title' => $request->title,
                'status' => $request->status,
                'image_id' => $request->faq_image,
            ]);

            return response()->json(['success' => true, 'message' => 'FAQs Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQsCategory $fAQsCategory , $id)
    {
        $faq = FAQsCategory::find($id);
        $faq = new FAQsResource($faq);
        // return $faq;
        // dd($faq->image);
        if ($faq->delete()) {
            return response()->json(['success' => true, 'message' => 'FAQs has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
