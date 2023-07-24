<?php

namespace App\Http\Controllers\Web;

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
    public function statusUdate(Request $request)
    {

        if (AttributeValue::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Attribute Value', $status), 'success' => true]);

        }
        return response()->json(['message' => ErrorMessage(), 'success' => false]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'status' => 'required',
            'attribute' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $attrebutevalue = AttributeValue::create([
            'attribute_value' => $request->value,
            'attribute_id' => $request->attribute,
            'status' => $request->status,
        ]);
        if ($attrebutevalue) {
            return redirect("/attribute/$request->attribute")->with('flash', [
                'success' => true,
                'message' =>   CreateMessage('Attribute Value ')
            ]);
        }
        return redirect("/attribute/$request->attribute")->with('flash', [
            'success' => false,
            'message' => ErrorMessage()
        ]);
    }


    public function edit(string $id)
    {
        $attributeValue = AttributeValue::find($id);
        if ($attributeValue) {
            return response()->json($attributeValue);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'value' => 'required',
            'status' => 'required',
            'attribute' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $attrebutevalue = AttributeValue::where(['id' => $request->id])->update([
            'attribute_value' => $request->value,
            'attribute_id' => $request->attribute,
            'status' => $request->status,
        ]);

        if ($attrebutevalue) {
            return redirect("/attribute/$id")->with('flash', [
                'success' => true,
                'message' => UpdateMessage('Attribute Value')
            ]);
        }
        return redirect("/attribute/$id")->with('flash', [
            'success' => false,
            'message' => ErrorMessage()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attributeValue = AttributeValue::find($id);

        if ($attributeValue->delete()) {
            return response()->json(['success' => true, 'message' =>  DeleteMessage('Attribute Value ')]);
        }
        return response()->json(['success' => false, 'message' => ErrorMessage()], 400);
    }
}