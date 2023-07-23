<?php

namespace App\Http\Controllers\Web;


use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Facades\Validator;
use App\Models\Image as CategoryImage;
use App\Http\Resources\Web\FAQsResource;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $faqs = new Faq();
        if ($request->q) {
            $faqs = $faqs->where('title', 'like', "%{$request->q}%");
        }
        $faqs = $faqs->paginate(10)->onEachSide(1)->appends(request()->query());
        $faqs = FAQsResource::collection($faqs);
        // return $faqs;
        return view('pages.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'artical' => 'required',
            'faq_category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faqs-category.show', $request->faq_category)->withErrors([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }
        // dd($request);
        $faq = Faq::create([
            'title' => $request->title,
            'artical' => $request->artical,
            'category_id' => $request->faq_category,
        ]);

        if ($faq) {
            return redirect()->route('faqs-category.show', $request->faq_category)->with('flash', ['success' => true, 'message' => CreateMessage('FAQs')]);
        }
        return redirect()->route('faqs-category.show', $request->faq_category)->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'artical' => 'required',
            'faq_category' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faqs-category.show', $request->faq_category)->withErrors([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $faq = Faq::find($id);
        if ($faq) {
            $faq = Faq::where(['id' => $id])->update([
                'title' => $request->title,
                'artical' => $request->artical,
                'category_id' => $request->faq_category,
            ]);
            if ($faq) {
                return redirect()->route('faqs-category.show', $request->faq_category)->with('flash', ['success' => true, 'message' => UpdateMessage('FAQs')]);
            }
            return redirect()->route('faqs-category.show', $request->faq_category)->with('flash', ['success' => false, 'message' => ErrorMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq, $id)
    {
        $faq = Faq::find($id);
        // $brand =new BrandResource($brand);
        // dd($category->image);
        if ($faq->delete()) {
            return response()->json(['success' => true, 'message' => 'FAQs has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
