<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\Validator;


class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attribute_value' => 'required',
            'status' => 'required|integer'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first()
                    ],400);
        }

        $attrebutevalue = AttributeValue::create([
            'attribute_value' => $request->attribute_value,
            'attribute_id' =>$request->attribute_id,
            'status' => $request->status,
        ]);

        return response()->json(['success'=>true,'message'=>'Attribute Value created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attributeValue= AttributeValue::find($id);
        if($attributeValue){
            return response()->json($attributeValue);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'attribute_value' => 'required',
            'status' => 'required|integer'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first()
                    ],400);
        }

        $attrebutevalue = AttributeValue::where(['id'=>$id])->update([
            'attribute_value' => $request->attribute_value,
            'attribute_id' =>$request->attribute_id,
            'status' => $request->status,
        ]);

        return response()->json(['success'=>true,'message'=>'Attribute Value updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $attributeValue = AttributeValue::find($id);

        if($attributeValue->delete()){
            return response()->json(['success'=>true,'message'=>'Attribute Value has been deleted successfully.']);
        }
        return response()->json(['success'=>false,'message'=>'Opps something went wrong!'],400);
    }
}
