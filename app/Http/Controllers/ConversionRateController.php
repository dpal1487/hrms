<?php

namespace App\Http\Controllers;

use App\Models\ConversionRate;
use Illuminate\Http\Request;
use App\Http\Resources\ConversionRateResources;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class ConversionRateController extends Controller
{
    public function index(Request $request)
    {
        $conversionrates = new ConversionRate();
        if (!empty($request->q)) {
            $conversionrates = $conversionrates
                ->where('currency_name', 'like', "%$request->q")
                ->orWhere('currency_value', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $conversionrates = $conversionrates->where('status', '=', $request->status);
        }
        return Inertia::render('ConversionRate/Index', [
            'conversionrates' => ConversionRateResources::collection($conversionrates->paginate(10)->appends($request->all())),
        ]);
    }

    public function create()
    {
        return Inertia::render('ConversionRate/Form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency_name' => 'required',
            'currency_value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }


        $conversionrate = ConversionRate::create([
            'currency_name' => $request->currency_name,
            'currency_value' => $request->currency_value,
        ]);

        if ($conversionrate) {
            return response()->json([
                'success' => true,
                'message' => 'Conversion Rate created successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Conversion Rate not created',
            ], 400);
        }
    }

    public function edit($id)
    {
        $conversionrate = ConversionRate::find($id);

        return Inertia::render('ConversionRate/Form', [
            'conversionrate' => new ConversionRateResources($conversionrate),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'currency_name' => 'required',
            'currency_value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        $conversionrate = ConversionRate::find($id);


        $conversionrate = ConversionRate::where(['id' => $id])->update([
            'currency_name' => $request->currency_name,
            'currency_value' => $request->currency_value,
        ]);

        if ($conversionrate) {
            return response()->json([
                'success' => true,
                'message' => 'Conversion Rate updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Conversion Rate not updated',
            ], 400);
        }

        // if ($conversionrate) {
        //     return redirect()
        //         ->route('conversion-rate.index')
        //         ->with('message', 'Conversion Rate updated Successfully');
        // }
        // return redirect()
        //     ->route('conversion-rate.index')
        //     ->with('message', 'Conversion Rate not updated');
    }

    public function destroy($id)
    {
        // dd($id);

        $conversionrate = ConversionRate::find($id);
        if ($conversionrate->delete()) {
            return response()->json(['success' => true, 'message' => 'Conversion Rate has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }

    public function conversionValue(Request $request, $id)
    {

        $conversionrate = ConversionRate::where('id', $id)->first();
        return new ConversionRateResources($conversionrate);
        if ($request->ajax()) {
            if ($conversionrate) {
                return response()->json([
                    'success' => true,
                    'data' => new ConversionRateResources($conversionrate),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong',
            ]);
        } else {
            return $this->errorAjax();
        }
    }
}
