<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\Attribute\AttributeCategoryValueResource;
use App\Http\Resources\Web\Attribute\AttributeListResurce;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Resources\Web\Attribute\AttributeSingleResource;
use App\Http\Resources\Web\Attribute\AttributeValueResource;
use App\Http\Resources\Web\Category\CategoryResource;
use App\Http\Resources\Web\RuleResource;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Rule as RuleModel;
use App\Models\AttributeRule;
use App\Models\CategoryAttributes;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{

    public function index(Request $request)
    {
        $attributes = new Attribute();
        if (!empty($request->q)) {
            $attributes = $attributes->where('name', 'like', "%{$request->q}%")
                ->orWhere('data_type', 'like', "%{$request->q}%")
                ->orWhere('field', 'like', "%{$request->q}%")
                ->orWhereHas('category', function ($category) use ($request) {
                    $category->where('name', 'like', "%{$request->q}%");
                });
        }
        if (!empty($request->s) || $request->s != '') {
            $attributes = $attributes->where('status', $request->s);
        }
        return Inertia::render('Attributes/Index', [
            'attributes' => AttributeListResurce::collection($attributes->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function statusUdate(Request $request)
    {
        if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Attribute', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    public function create()
    {
        $categories = Category::where('parent_id', '!=', null)->get();
        $rules = RuleModel::get();
        return Inertia::render('Attributes/Form', [
            'categories' => CategoryResource::collection($categories),
            'rules' => RuleResource::collection($rules),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:' . Attribute::class],
            'categories' => 'required',
            'field' => 'required',
            'input_type' => 'required',
            'data_type' => 'required',
            'display_order' => 'required|integer',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $attribute = Attribute::create([
            'name' => $request->name,
            'field' => $request->field,
            'input_type' => $request->input_type,
            'data_type' => $request->data_type,
            'description' => $request->description,
            'display_order' => $request->display_order,
            'status' => $request->status,
        ]);
        if ($attribute) {

            foreach ($request->categories as $categoryAttribute) {
                $categoryAttribute = CategoryAttributes::create([
                    'attribute_id' => $attribute->id,
                    'category_id' => $categoryAttribute,
                ]);
            }
            foreach ($request->rules as $key => $value) {
                $attributeRule =  AttributeRule::create([
                    'attribute_id' => $attribute->id,
                    'rule_id' => $value,
                ]);
            }
            return redirect()->route('attributes.index')->with('flash', ['message' =>  CreateMessage('Attribute')]);
        }
        return redirect()->route('attributes.index')->with('message', ErrorMessage());
    }

    public function show(Request $request, $id)
    {
        $attribute = Attribute::find($id);

        $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->get();

        $categories = Category::where('parent_id' , '!=' , null)->get();
        if ($attribute) {
            return Inertia::render('Attributes/Show', [
                'attribute' => new AttributeSingleResource($attribute),
                'categories' => CategoryResource::collection($categories),
                'values' => AttributeCategoryValueResource::collection($attributeValue),
            ]);
        }
        return redirect()->route('attributes.index')->with('message', ErrorMessage());
    }

    public function edit($id)
    {
        return Inertia::render('Attributes/Form', [
            'categories' => CategoryResource::collection(Category::get()),
            'rules' => RuleResource::collection(RuleModel::get()),
            'attribute' => new AttributeSingleResource(Attribute::find($id)),
        ]);
    }
    public function attributevalue($id)
    {
        $attributeValue = AttributeValue::find($id);

        return response()->json($attributeValue);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('attributes')->ignore($id),],
            'categories' => 'required',
            'field' => 'required',
            'input_type' => 'required',
            'data_type' => 'required',
            'display_order' => 'required|integer',
            'status' => 'required',
            'finalAttrbutes.*.id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $attribute = Attribute::find($id);
        if ($attribute) {
            $attribute = Attribute::where(['id' => $attribute->id])->update([
                'name' => $request->name == $attribute->name ? $attribute->name :   $request->name,
                'field' => $request->field,
                'input_type' => $request->input_type,
                'data_type' => $request->data_type,
                'description' => $request->description,
                'display_order' => $request->display_order,
                'status' => $request->status,
            ]);
            $attributeRule = AttributeRule::where('attribute_id', '=', $id)->delete();
            $attributeRule = CategoryAttributes::where('attribute_id', '=', $id)->delete();
            if ($attribute) {
                foreach ($request->categories as $categoryAttribute) {
                    $categoryAttribute = CategoryAttributes::create([
                        'attribute_id' => $id,
                        'category_id' => $categoryAttribute,
                    ]);
                }
                foreach ($request->rules as $key => $value) {
                    AttributeRule::create([
                        'attribute_id' => $id,
                        'rule_id' => $value,
                    ]);
                }
            }
            return redirect()->route('attributes.index')->with('flash', ['message' =>  UpdateMessage('Attribute')]);
        }
        return redirect()->route('attributes.index')->with('message', ErrorMessage());
    }
    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if ($attribute->delete()) {
            return response()->json(['success' => true, 'message' =>  DeleteMessage('Attribute')]);
        }
        return response()->json(['success' => false, 'message' => ErrorMessage()]);
    }
}
