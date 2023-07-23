<?php

namespace App\Http\Controllers\Web;


use App\Http\Resources\Web\FAQsCategoryResource;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\FAQsCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Image as CategoryImage;
use App\Http\Resources\Web\FAQsResource;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FaqsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $faqs_categories = new FAQsCategory();
        if (!empty($request->q)) {
            $faqs_categories = $faqs_categories->where('title', 'like', "%{$request->q}%");
        }
        if (!empty($request->s || $request->s != '')) {
            $faqs_categories = $faqs_categories->where('status', $request->s);
        }
        return Inertia::render('FaqsCategory/Index', [
            'faqs_categories' => FAQsResource::collection($faqs_categories->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function statusUdate(Request $request)
    {
        if (FAQsCategory::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Faqs Category', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }


    public function create()
    {
        return Inertia::render('FaqsCategory/Form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        // dd($request);
        $faqCategories = FAQsCategory::create([
            'title' => $request->title,
            'status' => $request->status,
            'image_id' => $request->image_id,
        ]);

        if ($faqCategories) {
            return redirect('faqs-categories')->with('flash', [
                'success' => true,
                'message' => CreateMessage('FAQs Category')
            ]);
        }
        return redirect('faqs-categories')->with('flash', [
            'success' => false,
            'message' => ErrorMessage()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Inertia::render('FaqsCategory/Show', [
            'faq_category' => new FAQsCategoryResource(FAQsCategory::find($id)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return Inertia::render('FaqsCategory/Form', [
            'faqs_category' => new FAQsResource(FAQsCategory::find($id)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQsCategory $fAQsCategory, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        $faqCategories = FAQsCategory::find($id);
        if ($faqCategories) {
            $faqCategories = FAQsCategory::where(['id' => $id])->update([
                'title' => $request->title,
                'status' => $request->status,
                'image_id' => $request->image_id,
            ]);

            if ($faqCategories) {
                return redirect('faqs-categories')->with('flash', [
                    'success' => true,
                    'message' => UpdateMessage('FAQs Category')
                ]);
            }
            return redirect('faqs-categories')->with('flash', [
                'success' => false,
                'message' => ErrorMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        $faqCategory = FAQsCategory::find($id);
        if ($faqCategory->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('FAQs Category')]);
        }
        return response()->json(['success' => false, 'message' => ErrorMessage()]);
    }
}
