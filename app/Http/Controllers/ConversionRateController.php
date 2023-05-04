<?php

namespace App\Http\Controllers;

use App\Models\ConversionRate;
use Illuminate\Http\Request;
use App\Http\Resources\ConversionRateResources;
use Inertia\Inertia;

class ConversionRateController extends Controller
{
    public function index(Request $request)
    {
        $conversionrates = new ConversionRate();
        if (!empty($request->q)) {
            $conversionrates = $conversionrates
                ->where('currency_name', 'like', "%$request->q")
                ->orWhere('currency_value', 'like', "%$request->q%")
                ->orWhere('conversion_rate', 'like', "%$request->q%")
                ->orWhere('inr_amount', 'like', "%$request->q%")
                ->orWhere('actual_value', 'like', "%$request->q%");
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
        // $questions = Question::get();
        return Inertia::render('ConversionRate/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency_name' => 'required',
            'currency_value' => 'required',
            'conversion_rate' => 'required',
            'inr_amount' => 'required',
            'actual_value' => 'required',
            'status' => 'required',
        ]);

        if (
            $ConversionRate = ConversionRate::create([
                'currency_name' => $request->currency_name,
                'currency_value' => $request->currency_value,
                'conversion_rate' => $request->conversion_rate,
                'inr_amount' => $request->inr_amount,
                'actual_value' => $request->actual_value,
                'status' => $request->status,
            ])
        ) {
            // return response()->json(['success' => true, 'message' => 'ConversionRate created successfully']);

            return redirect('/conversion-rate')->with(['message' => 'Conversion Rate created successfully']);
        }
    }

    public function edit($id)
    {
        $conversionrate = ConversionRate::find($id);

        return Inertia::render('ConversionRate/Form', [
            'conversionrate' => new ConversionRateResources($conversionrate),
        ]);
    }

    public function update(Request $request, ConversionRate $ConversionRate, $id)
    {
        $request->validate([
            'currency_name' => 'required',
            'currency_value' => 'required',
            'conversion_rate' => 'required',
            'inr_amount' => 'required',
            'actual_value' => 'required',
            'status' => 'required',
        ]);

        $conversionrate = ConversionRate::find($id);

        if (
            $conversionrate = ConversionRate::where(['id' => $conversionrate->id])->update([
                'currency_name' => $request->currency_name,
                'currency_value' => $request->currency_value,
                'conversion_rate' => $request->conversion_rate,
                'inr_amount' => $request->inr_amount,
                'actual_value' => $request->actual_value,
                'status' => $request->status,
            ])
        ) {
            return redirect('/conversion-rate')->with(['message' => 'Conversion Rate Updated successfully']);

            // return response()->json([
            //     'success' => true,
            //     'message' => 'Conversion Rate Updated successfully',
            //     'redirect' => '/address',
            // ]);

            // return redirect('/ConversionRate');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong !',
                'redirect' => '/address',
            ]);
        }
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
        $conversionrate = ConversionRate::where('id',$id)->first();
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