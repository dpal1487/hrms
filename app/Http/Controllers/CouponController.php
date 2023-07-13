<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Resources\CouponResource;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupons = new Coupon();
        if ($request->q) {
            $coupons = $coupons->where('code', 'like', "%{$request->q}%");
        }
        $coupons = $coupons->paginate(10)->onEachSide(1)->appends(request()->query());
        $coupons = CouponResource::collection($coupons);
        return view('pages.coupons.index', compact('coupons'));
    }
    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //         return response()->json(['message' => "Your Status has been " . $status, 'success' => true]);
    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.coupons.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'expires_in_days' => 'required',
            'type' => 'required',
            'discount' => 'required',
            'description' => 'required',
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

        $coupon = Coupon::create([
            'code' => $request->code,
            'expires_at' => $request->expires_in_days,
            'type' => $request->type,
            'discount' => $request->discount,
            'descriptions' => $request->description,
        ]);

        return response()->json(['success' => true, 'message' => 'Coupon created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon, $id)
    {
        $coupon = Coupon::find($id);
        $coupon = new CouponResource($coupon);
        return view('pages.coupons.edit', ['coupon' => $coupon]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon , $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'expires_in_days' => 'required',
            'type' => 'required',
            'discount' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon = Coupon::where(['id' => $id])->update([
                'code' => $request->code,
                'expires_at' => $request->expires_in_days,
                'type' => $request->type,
                'discount' => $request->discount,
                'descriptions' => $request->description,
            ]);

            return response()->json(['success' => true, 'message' => 'Coupon Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon , $id)
    {
        $coupon = Coupon::find($id);
        $coupon = new CouponResource($coupon);
        if ($coupon->delete()) {
            return response()->json(['success' => true, 'message' => 'Coupon has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
