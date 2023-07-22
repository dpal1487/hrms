<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Models\Image as DBImage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function categoryThumbnail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $image = $request->file('image');
        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/category/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);

            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;
            $largethumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_large_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/category/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/category/thumbnail/medium/';
            $largeThumbnailFolder = 'assets/images/category/thumbnail/large/';

            $result->resize(100, 110);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(150, 150);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $result = $result->save($file_path . '/thumbnail/large/' . $largethumbnail);

            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'small_path' => url($smallThumbnailFolder . $smallthumbnail),
                'medium_path' => url($mediumThumbnailFolder . $mediumthumbnail),
                'large_path' => url($largeThumbnailFolder . $largethumbnail),
            ]);

            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }
    public function bannerImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $image = $request->file('image');
        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/banner/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;
            $largethumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_large_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/banner/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/banner/thumbnail/medium/';
            $largeThumbnailFolder = 'assets/images/category/thumbnail/large/';

            $result->resize(100, 110);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(150, 150);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);
            $result = $result->save($file_path . '/thumbnail/large/' . $largethumbnail);

            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'small_path' => url($smallThumbnailFolder . $smallthumbnail),
                'medium_path' => url($mediumThumbnailFolder . $mediumthumbnail),
                'large_path' => url($largeThumbnailFolder . $largethumbnail),
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }
    public function uploadBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $image = $request->file('image');
        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/banner/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;
            $largethumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_large_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/banner/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/banner/thumbnail/medium/';
            $largeThumbnailFolder = 'assets/images/category/thumbnail/large/';

            $result->resize(100, 110);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(150, 150);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);
            $result = $result->save($file_path . '/thumbnail/large/' . $largethumbnail);


            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'small_path' => url($smallThumbnailFolder . $smallthumbnail),
                'medium_path' => url($mediumThumbnailFolder . $mediumthumbnail),
                'large_path' => url($largeThumbnailFolder . $largethumbnail),
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }

    public function uploadFAQsImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $image = $request->file('image');
        if ($image) {
            $extension = $request->image->extension();
            $file_path = 'assets/images/faq_category/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($file_path . 'original/' . $name);
            $smallthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_small_' . '.' . $extension;
            $mediumthumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_medium_' . '.' . $extension;
            $largethumbnail = date('mdYHis') . '-' . uniqid() . '.' . '_large_' . '.' . $extension;

            $smallThumbnailFolder = 'assets/images/faq_category/thumbnail/small/';
            $mediumThumbnailFolder = 'assets/images/faq_category/thumbnail/medium/';
            $largeThumbnailFolder = 'assets/images/faq_category/thumbnail/large/';

            $result->resize(100, 110);
            $result = $result->save($file_path . '/thumbnail/small/' . $smallthumbnail);

            $result->resize(150, 150);
            $result = $result->save($file_path . '/thumbnail/medium/' . $mediumthumbnail);

            $result = $result->save($file_path . '/thumbnail/large/' . $largethumbnail);


            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'small_path' => url($smallThumbnailFolder . $smallthumbnail),
                'medium_path' => url($mediumThumbnailFolder . $mediumthumbnail),
                'large_path' => url($largeThumbnailFolder . $largethumbnail),
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }
}
