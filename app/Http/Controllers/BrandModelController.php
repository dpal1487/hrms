<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BrandModel;
use Illuminate\Support\Str;


class BrandModelController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|integer',
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

        $brandmodel = BrandModel::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'brand_id' =>$request->brand_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Brand Model created successfully']);
    }

    public function edit(string $id)
    {
        $brandmodel = BrandModel::find($id);
        if ($brandmodel) {
            return response()->json($brandmodel);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|integer',
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

        $brandmodel = BrandModel::where(['id' => $id])->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
            'brand_id' =>$request->brand_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Brand Model updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brandmodel = BrandModel::find($id);

        if ($brandmodel->delete()) {
            return response()->json(['success' => true, 'message' => 'Brand Model has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
