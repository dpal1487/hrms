<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Meta;
use Illuminate\Http\Request;
use App\Http\Resources\PageResource;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $pages = new Page();
        if ($request->q) {
            $pages = $pages->where('title', 'like', "%{$request->q}%");
        }
        $pages = $pages->paginate(10)->onEachSide(1)->appends(request()->query());
        $pages = PageResource::collection($pages);
        // return $pages;
        return view('pages.pages.index', compact('pages'));
    }
    // public function statusUdate(Request $request)
    // {

    //     if (Attribute::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
    //         $status = $request->status == 0  ? "Inactive" : "Active";
    //         return response()->json(['message' => "Your Status has been " . $status, 'success' => true]);
    //     }
    //     return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $metas = Meta::get();
        return view('pages.pages.add',['metas' => $metas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'heading' => 'required',
            'meta' => 'required',
            'status' => 'required',
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

        $page = Page::create([
            'title' => $request->title,
            'heading' => $request->heading,
            'meta_id' => $request->meta,
            'status' => $request->status,
        ]);

        return response()->json(['success' => true, 'message' => 'Page created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page , $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page , $id)
    {
        $metas = Meta::get();

        $page = Page::find($id);
        $page = new PageResource($page);
        // return $page;
        return view('pages.pages.edit', ['page' => $page , 'metas' => $metas]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page ,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'heading' => 'required',
            'meta' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ]);
        }
        $page = Page::find($id);
        if ($page) {
            $page = Page::where(['id' => $id])->update([
                'title' => $request->title,
            'heading' => $request->heading,
            'meta_id' => $request->meta,
            'status' => $request->status,
            ]);

            return response()->json(['success' => true, 'message' => 'Page Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page , $id)
    {
        $page = Page::find($id);
        $page = new PageResource($page);
        if ($page->delete()) {
            return response()->json(['success' => true, 'message' => 'Page has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
