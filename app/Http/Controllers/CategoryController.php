<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryBanner;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = new Category();
        if (!empty($request->q)) {
            $categories = $categories->where('name', 'like', "%{$request->q}%");
        }
        if (!empty($request->s || $request->s != '')) {
            $categories = $categories->where('status', $request->s);
        }
        return Inertia::render('Category/Index', [
            'categories' => CategoryResource::collection($categories->paginate(10)->appends($request->all())),
        ]);
    }
    public function create()
    {
        $categoryParent = Category::where('parent_id', '=', NULL)->get();
        return Inertia::render('Category/Form', [
            'category_parent' => (CategoryResource::collection($categoryParent)),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'keyword' => 'required',
            'meta_description' => 'required',
            'meta_tag' => 'required',
            'meta_keyword' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $meta = Meta::create([
            'description' => $request->meta_description,
            'tag' => $request->meta_tag,
            'keywords' => $request->meta_keyword,
        ]);
        if ($meta) {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'keywords' => $request->keyword,
                'parent_id' => $request->parent_id,
                'meta_id' => $meta->id,
                'image_id' => $request->image_id,
            ]);
            if ($category) {
                CategoryBanner::create(
                    [
                        'category_id' => $category->id,
                        'image_id' => $request->banner_image,
                        'order_by' => 1,
                    ]
                );
                return response()->json(['success' => true, 'message' => 'Category created successfully']);
            }
        }
        return response()->json(['success' => true, 'message' => 'Meta created failed']);
    }

    public function edit($id)
    {
        $categoryParent = Category::where('parent_id', '=', NULL)->get();
        $category = Category::find($id);

        return Inertia::render('Category/Form', [
            'category_parent' => (CategoryResource::collection($categoryParent)),
            'category' => new CategoryResource($category)
        ]);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'keyword' => 'required',
            'meta_description' => 'required',
            'meta_tag' => 'required',
            'meta_keyword' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ]);
        }
        $category = Category::find($id);
        if ($category) {
            if ($category->meta_id != 0 || $category->meta_id != '') {
                $meta = Meta::create([
                    'description' => $request->meta_description,
                    'tag' => $request->meta_tag,
                    'keywords' => $request->meta_keyword,
                ]);
            } else {
                $meta = Meta::where(['id' => $category->meta_id])->update([
                    'description' => $request->meta_description,
                    'tag' => $request->meta_tag,
                    'keywords' => $request->meta_keyword,
                ]);
            }
            if ($meta) {
                $category = Category::where(['id' => $id])->update([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'keywords' => $request->keyword,
                    'parent_id' => $request->parent,
                    'image_id' => $request->image_id ? $request->image_id : $category->image_id,
                    'meta_id' => $meta->id,
                ]);
                if ($category) {
                    CategoryBanner::where(['category_id' => $id])->update([
                        'image_id' => $request->banner_image,
                    ]);
                    return response()->json(['success' => true, 'message' => UpdateMessage('Category')]);
                }
            }
            return response()->json(['success' => true, 'message' => ErrorMessage('Category')]);
        }
    }

    public function statusUdate(Request $request)
    {
        if (Category::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Category', $status), 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category = new CategoryResource($category);
        if ($category->delete()) {
            return response()->json(['message' =>  'Category ' . DeleteMessage(), 'success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
