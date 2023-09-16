<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Models\CategoryAttributeValue;
use Illuminate\Support\Facades\Validator;


class AttributeValueController extends Controller
{
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
        $categoryAttributeValue = CategoryAttributeValue::create([
            'category_id' => $request->category,
            'attribute_id' => $request->attribute,
            'value_id' => $attrebutevalue->id
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
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
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

        $attrebutevalue = AttributeValue::where('id' , $request->id)->update([
            'attribute_value' => $request->value,
            'attribute_id' => $request->attribute,
            'status' => $request->status,
        ]);
        $categoryAttributeValue = CategoryAttributeValue::where('value_id' , $request->id)->first();
        if ($categoryAttributeValue)
        {
        $categoryAttributeValue = $categoryAttributeValue->update([
            'category_id' => $request->category,
            'attribute_id' => $request->attribute,
        ]);
    }
    else{
        $categoryAttributeValue = CategoryAttributeValue::create([
            'category_id' => $request->category,
            'attribute_id' => $request->attribute,
            'value_id' => $request->id
        ]);
    }

        if ($attrebutevalue) {
            return redirect("/attribute/$request->attribute")->with('flash', [
                'success' => true,
                'message' => UpdateMessage('Attribute Value')
            ]);
        }
        return redirect("/attribute/$request->attribute")->with('flash', [
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
        $categoryAttributeValue = CategoryAttributeValue::where('value_id',$attributeValue->id)->first();

        if ($attributeValue->delete()) {
            $categoryAttributeValue->delete();
            return response()->json(['success' => true, 'message' =>  DeleteMessage('Attribute Value ')]);
        }
        return response()->json(['success' => false, 'message' => ErrorMessage()], 400);
    }
}
