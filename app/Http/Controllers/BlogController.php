<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blogs = new Blog();
        // return $blogs;
        if (!empty($request->q)) {
            $blogs = $blogs
                ->where('title', 'like', "%$request->q")
                ->orWhere('content', 'like', "%$request->q%");
        }
        if (!empty($request->s) || $request->s != '') {
            $blogs = $blogs->where('is_published', '=', $request->s);
        }
        if ($request->expectsJson()) {

            return BlogResource::collection($blogs->paginate(10));
        }
        return Inertia::render('Blog/Index', [
            'blogs' => BlogResource::collection($blogs->paginate(10)->appends($request->all())),
        ]);
    }

    public function statusUpdate(Request  $request)
    {
        if (Blog::where(['id' => $request->id])->update(['is_published' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Unpublished" : "Published";
            return response()->json(['message' => "Your Blog has been " . $status, 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }
    public function create()
    {
        return Inertia::render('Blog/Form');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_id' => 'required',
            'content' => 'required',
            'is_published' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image_id' => $request->image_id,
            'content' => $request->content,
            'is_published' => $request->is_published,
        ]);
        if ($blog) {
            return redirect('blog')->with('flash', [
                'success' => true,
                'message' => 'Blog create successfully',
            ]);
        }
        return redirect('blog');
    }


    public function show(Request $request, $id)
    {
        $blog = Blog::find($id);

        if ($request->expectsJson()) {
            return response()->json([
                'data' => new BlogResource($blog),
            ]);
        }

        return Inertia::render('Blog/Show', [
            'blog' => new BlogResource($blog),
        ]);
        // return response()->json(['data' => $data, 'success' => true]);
    }


    public function edit(Blog $blog)
    {
        return Inertia::render('Blog/Form', [
            'blog' => new BlogResource($blog),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image_id' => 'required',
            'content' => 'required',
            'is_published' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['message' => $validator->errors()->first(), 'success' => false]);
        }
        if ($request->image_id) {
            $blog = Blog::where(['id' => $blog->id])->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image_id' => $request->image_id,
                'content' => $request->content,
                'is_published' => $request->is_published,
            ]);
        } else {
            $blog = Blog::where(['id' => $blog->id])->update([
                'title' => $request->title,
                'content' => $request->content,
                'is_published' => $request->is_published,
            ]);
        }

        if ($blog) {
            return redirect('blog')->with('flash', [
                'success' => true,
                'message' => 'Blog updated successfully',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Blog not updated',
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        if ($blog->delete()) {
            return response()->json(['success' => true, 'message' => 'Blog has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!'], 400);
    }
}
