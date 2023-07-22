<?php

namespace App\Http\Controllers;

use App\Http\Resources\MetaResource;
use App\Models\Page;
use App\Models\Meta;
use Illuminate\Http\Request;
use App\Http\Resources\PageResource;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pages = new Page();
        if (!empty($request->q)) {
            $pages = $pages->where('title', 'like', "%{$request->q}%")
                ->orWhere('heading', 'like', "%{$request->q}%")
                ->orWhereHas('meta', function ($query) use ($request) {
                    $query->where('tag', 'like', "%{$request->q}%");
                });
        }
        if (!empty($request->s) || ($request->s != '')) {
            $pages = $pages->where('status', $request->s);
        }

        return Inertia::render('Pages/Index', [
            'pages' => PageResource::collection($pages->paginate(10)->onEachSide(1)->appends(request()->query()))
        ]);
    }
    public function statusUdate(Request $request)
    {
        if (Page::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => StatusMessage('Page', $status), 'success' => true]);

        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pages/Form', [
            'metas' => MetaResource::collection(Meta::get())
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'heading' => 'required',
            'meta' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ],
            );
        }

        $page = Page::create([
            'title' => $request->title,
            'heading' => $request->heading,
            'meta_id' => $request->meta,
            'status' => $request->status,
        ]);

        if ($page) {
            return redirect()->route('pages.index')->with('flash', [
                'success' => true,
                'message' =>  CreateMessage('Page')
            ]);
        } else {
            return redirect()->back()->with('flash', [
                'success' => false,
                'message' => ErrorMessage()
            ]);
        }
    }
    public function edit($id)
    {
        return Inertia::render('Pages/Form', [
            'page' => new PageResource(Page::find($id)),
            'metas' => MetaResource::collection(Meta::get())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page, $id)
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

        $page = Page::where(['id' => $id])->update([
            'title' => $request->title,
            'heading' => $request->heading,
            'meta_id' => $request->meta,
            'status' => $request->status,
        ]);

        if ($page) {
            return redirect()->route('pages.index')->with('flash', [
                'success' => true,
                'message' =>  UpdateMessage('Page')
            ]);
        } else {
            return redirect()->back()->with('flash', [
                'success' => false,
                'message' => ErrorMessage()
            ]);
        }
    }


    public function destroy(Page $page, $id)
    {
        $page = Page::find($id);
        if ($page->delete()) {
            return response()->json(['success' => true, 'message' => DeleteMessage('Page')]);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
