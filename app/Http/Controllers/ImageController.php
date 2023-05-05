<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Image as DBImage;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function empImage(Request $request)
    {
        $image = $request->file('image');
        //  dd($image);

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/users/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/users/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/users/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);
            if ($Imagefile) {
                return response()->json([
                    'success' => true,
                    // 'message' => 'Image uploade successfull',
                    'data' => $Imagefile,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image uploade Fail',
            ]);
        }
    }
    public function indImage(Request $request)
    {
        $image = $request->file('image');
        //  dd($image);

        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/industry/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/industry/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/industry/thumbnail/medium/';

            // $result = $result->save($file_path.'original/'.$name);

            $result->resize(200, 200);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(100, 100);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $Imagefile = DBImage::create([
                'name' => $name,
                'original_path' => url($file_path),
                'small_path' => url($file_path . $name),
                'medium_path' => url($smallThumbnailFolder . $smallthumbnail),
                'large_path' => url($mediumThumbnailFolder . $mediumthumbnail),
            ]);

            if ($Imagefile) {
                return response()->json([
                    'success' => true,
                    // 'message' => 'Industry Image uploade',
                    'data' => $Imagefile,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image uploade Fail',

            ]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $images = DBImage::get();

        return Inertia::render('Image/Show', [
            'images' => $images,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
