<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerReviewResource;
use Inertia\Inertia;

class CustomerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $reviews = new CustomerReview();
        if (!empty($request->q)) {
            $reviews = $reviews->whereHas('user', function ($user) use ($request) {
                $user->where('first_name', 'like', "%{$request->q}%")->orWhere('first_name', 'like', "%{$request->q}%");
            })
                ->orWhereHas('review', function ($review) use ($request) {
                    $review->where('title', 'like', "%{$request->q}%")->orWhere('content', 'like', "%{$request->q}%");
                });
        }
        return Inertia::render('CustomerReviews/Index', [
            'customer_reviews' => CustomerReviewResource::collection($reviews->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }

    public function statusUdate(Request $request)
    {

        if (CustomerReview::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Customer Review', $status), 'success' => true]);

        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.customer-review.add');
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
        $faq = CustomerReview::create([
            'title' => $request->title,
            'status' => $request->status,
            'image_id' => $request->faq_image,
        ]);

        return response()->json(['success' => true, 'message' => 'Customer Review Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerReview $customerReview)
    {
        $faq = CustomerReview::find($id);
        $faq = new CustomerReviewResource($faq);
        // return $faq;
        return view('pages.customer-review.view', ['faq' => $faq]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerReview $customerReview)
    {

        $faq = CustomerReview::find($id);
        $faq = new CustomerReviewResource($faq);
        return view('pages.customer-review.edit', ['faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerReview $customerReview)
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

        $faq = CustomerReview::find($id);
        if ($faq) {
            $faq = CustomerReview::where(['id' => $id])->update([
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
    public function destroy(CustomerReview $customerReview)
    {
        $faq = CustomerReview::find($id);
        $faq = new CustomerReviewResource($faq);
        // return $faq;
        // dd($faq->image);
        if ($faq->delete()) {
            return response()->json(['success' => true, 'message' => 'Customer Review has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
