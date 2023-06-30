<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TestimonialController extends Controller
{
    private $data;

    public function index(Request $request)
    {
        $testimonials = new Testimonial();
        if (!empty($request->q)) {
            $testimonials = $testimonials
                ->where('name', 'like', "%$request->q")
                ->orWhere('testimonial', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $testimonials = $testimonials->where('is_published', '=', $request->status);
        }
        if ($request->expectsJson()) {
            if ($testimonials) {
                return TestimonialResource::collection($testimonials->paginate(10));
            } else {
                return response()->json(['data' => [], 'success' => true]);
            }
        }
        return Inertia::render('Testimonial/Index', [
            'testimonials' => TestimonialResource::collection($testimonials->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('Testimonial/Form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'testimonial' => 'required',
            'is_published' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'testimonial' => $request->testimonial,
            'is_published' => $request->is_published,

        ]);
        if ($testimonial) {
            return redirect('/testimonial')->with('flash', [
                'success' => true,
                'message' => 'testimonial created Successfully',
            ]);
        }
        return redirect('/testimonial')->with('flash', [
            'success' => false,
            'message' => 'testimonial not created'
        ]);
    }

    public function statusUpdate(Request  $request)
    {
        if (Testimonial::where(['id' => $request->id])->update(['is_published' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Unpublished" : "Published";
            return response()->json(['message' => "Your Testimonial has been " . $status, 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
    public function show(Testimonial $testimonial)
    {
        // $testimonial = new TestimonialResource($testimonial);

        return Inertia::render('Testimonial/Show', [
            'testimonial' => new TestimonialResource($testimonial),
        ]);
        // return response()->json(['data' => $data, 'success' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        return Inertia::render('Testimonial/Form', [
            'testimonial' => new TestimonialResource($testimonial),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'testimonial' => 'required',
            'is_published' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $testimonial = Testimonial::where(['id' => $testimonial->id])->update([
            'name' => $request->name,
            'testimonial' => $request->testimonial,
            'is_published' => $request->is_published,
        ]);

        if ($testimonial) {
            return redirect('testimonial')->with('flash', [
                'success' => true,
                'message' => 'Testimonial updated successfully',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Testimonial not updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->delete()) {
            return response()->json(['success' => true, 'message' => 'Testimonial has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
