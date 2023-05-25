<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Resources\CurrencyResource;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currencies = new Currency();
        if (!empty($request->q)) {
            $currencies = $currencies
                ->where('currency_name', 'like', "%$request->q")
                ->orWhere('currency_value', 'like', "%$request->q%");
        }
        if (!empty($request->status) || $request->status != '') {
            $currencies = $currencies->where('status', '=', $request->status);
        }
        return Inertia::render('Currency/Index', [
            'currencies' => CurrencyResource::collection($currencies->paginate(10)->appends($request->all())),
        ]);
    }

    public function currenctValue(Request $request, $id)
    {
        $currency = Currency::where('id', $id)->first();
        // return new CurrencyResource($currency);
        if ($request->ajax()) {
            if ($currency) {
                return response()->json([
                    'success' => true,
                    'data' => new CurrencyResource($currency),
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


    public function statusUpdate(Request  $request)
    {

        $currency  = Currency::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        if ($currency) {

            return response()->json([
                'success' => true,
                'message' => 'Status Update successfully',
            ]);
        } else {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }
    }


    public function create()
    {
        return Inertia::render('Currency/Form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency_name' => 'required',
            'currency_value' => 'required',
            'symbols' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }
        $currency = Currency::create([
            'currency_name' => $request->currency_name,
            'currency_value' => $request->currency_value,
            'symbols' => $request->symbols,
            'status' => $request->status,
        ]);

        if ($currency) {
            return response()->json([
                'success' => true,
                'message' => 'Currency created successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Currency not created',
            ], 400);
        }
    }
    public function show(Currency $currency)
    {
        //
    }


    public function edit(Currency $currency)
    {
        // $conversionrate = ConversionRate::find($id);

        return Inertia::render('Currency/Form', [
            'currency' => new CurrencyResource($currency),
        ]);
    }


    public function update(Request $request, Currency $currency)
    {
        $validator = Validator::make($request->all(), [
            'currency_name' => 'required',
            'currency_value' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'success' => false], 400);
        }

        $currency = Currency::where(['id' => $currency->id])->update([
            'currency_name' => $request->currency_name,
            'currency_value' => $request->currency_value,
            'symbols' => $request->symbols,
            'status' => $request->status,
        ]);

        if ($currency) {
            return response()->json([
                'success' => true,
                'message' => 'Currency updated successfully',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Currency not updated',
            ], 400);
        }
    }


    public function destroy(Currency $currency)
    {
        // $currency = Currency::find($id);
        if ($currency->delete()) {
            return response()->json(['success' => true, 'message' => 'Currency has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
    public function selectDelete(Request $request)
    {
        $currency = Currency::whereIn('id', $request->ids)->delete();

        if ($currency) {
            return response()->json(['success' => true, 'message' => 'Currency has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
