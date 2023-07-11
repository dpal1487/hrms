<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Resources\AttributeResource;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Rule;
use App\Models\AttributeRule;
use Illuminate\Support\Facades\Validator;
use DB;

class AttributeController extends Controller
{

    public function index(Request $request)
    {

        $attributes = new Attribute();
        if($request->q){
            $attributes = $attributes->where('name','like',"%{$request->q}%");
        }
        $attributes = $attributes->paginate(10)->onEachSide(1)->appends(request()->query());
        $attributes = AttributeResource::collection($attributes);

        // return $attributes;

        return view('pages.attribute.index' , compact('attributes' ));
    }

    public function create(Request $request)
    {
        $segments = $request->segments();
        $category = Category::get();

        $rules = Rule::get();
        return view('pages.attribute.add', ['category' =>$category , 'rules' => $rules , 'segments' =>$segments]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:'.Attribute::class],
            'category' => 'required',
            'field' => 'required',
            'type' => 'required',
            'display_order' => 'required|integer',
            'status' => 'required|integer',
            'add_rule_conditions.*.rule' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors()->first()
                    ],400);
        }

        $attribute = Attribute::create([
            'name' => $request->name,
            'field' =>$request->field,
            'category_id' =>$request->category,
            'type' => $request->type,
            'data_type' =>$request->data_type,
            'description' => $request->description,
            'display_order' =>$request->display_order,
            'status' => $request->status,
        ]);
        foreach ($request->add_rule_conditions as $key => $value) {
            AttributeRule::create([
                'attribute_id' =>$attribute->id,
                'rule_id' => $value['rule'],
            ]);
        }
        return response()->json(['success'=>true,'message'=>'Attribute created successfully']);
    }

    public function show($id)
    {
        $attribute = Attribute::find($id);
        $attribute = new AttributeResource($attribute);


        // return $attribute;
        return view('pages.attribute.view' , [ 'attribute' => $attribute  ] );
    }

    public function edit(Request $request, $id)
    {
        $segments = $request->segments();
        $category = Category::get();
        $rules = Rule::get();
        $attribute = Attribute::find($id);
        $attribute = new AttributeResource($attribute);
        // return $attribute;

        return view('pages.attribute.edit' , [ 'attribute' => $attribute , 'category' =>$category , 'rules' => $rules , 'segments' =>$segments ]);
    }
    public function attributevalue($id)
    {
        $attributeValue = AttributeValue::find($id);

        return response()->json($attributeValue);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'field' => 'required',
            'type' => 'required',
            'display_order' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()->all()
                    ]);
        }
        $attribute = Attribute::find($id);
        if($attribute){
            $attribute = Attribute::where(['id'=>$attribute->id])->update([
                'name' => $request->name,
                'field' =>$request->field,
                'category_id' =>$request->category,
                'type' => $request->type,
                'data_type' =>$request->data_type,
                'description' => $request->description,
                'display_order' =>$request->display_order,
                'status' => $request->status,
            ]);

            $attributeRule = DB::table('attribute_rules')
            ->where('attribute_id', '=', $id)
            ->delete();


            foreach ($request->add_rule_conditions as $key => $value) {
            AttributeRule::create([
                'attribute_id' =>$id,
                'rule_id' => $value['rule'],
            ]);
        }

            return response()->json(['success'=>true,'message'=>'Attribute Updated successfully']);

        }
    }
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if($attribute->delete()){
            return response()->json(['success'=>true,'message'=>'Attribute has been deleted successfully.']);
        }
        return response()->json(['success'=>false,'message'=>'Opps something went wrong!'],400);
    }

}
