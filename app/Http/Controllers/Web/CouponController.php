<?php

namespace App\Http\Controllers\Web;


use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Resources\Web\CouponResource;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupons = new Coupon();
        if (!empty($request->q)) {
            $coupons = $coupons->where('code', 'like', "%{$request->q}%")
                ->orWhere('descriptions', 'like', "%{$request->q}%")
                ->orWhere('type', 'like', "%{$request->q}%")
                ->orWhere('discount', 'like', "%{$request->q}%");
        }
        return Inertia::render('Coupons/Index', [
            'coupons' => CouponResource::collection($coupons->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function create()
    {
        return Inertia::render('Coupons/Form');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'expires' => 'required',
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
            'expires_at' => $request->expires,
            'type' => $request->type,
            'discount' => $request->discount,
            'descriptions' => $request->description,
        ]);

        if ($coupon) {

            return redirect()->route('coupons.index')->with('flash', ['success' => true, 'message' => CreateMessage('Coupon')]);
        }
        return redirect()->route('coupons')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
    }

    public function edit($id)
    {
        return Inertia::render('Coupons/Form', [
            'coupon' => new CouponResource(Coupon::find($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon, $id)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'expires' => 'required',
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
                'expires_at' => $request->expires,
                'type' => $request->type,
                'discount' => $request->discount,
                'descriptions' => $request->description,
            ]);
            if ($coupon) {
                return redirect()->route('coupons.index')->with('flash', ['success' => true, 'message' => UpdateMessage('Coupon')]);
            }
            return redirect()->route('coupons.index')->with('flash', ['success' => false, 'message' => ErrorMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon, $id)
    {
        $coupon = Coupon::find($id);
        $coupon = new CouponResource($coupon);
        if ($coupon->delete()) {
            return response()->json(['success' => true, 'message' => 'Coupon has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
