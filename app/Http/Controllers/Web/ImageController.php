<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Image;
use App\Models\Image as DBImage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
            $name = time() . '_' . $request->image->getClientOriginalName();
            $folder = 'assets/images/category/';
            $result = Image::make($image)->save($folder . $name);
            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }
    public function categoryBanner(Request $request)
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
            $name = time() . '_' . $request->image->getClientOriginalName();
            $folder = 'assets/images/banner/category/';
            $result = Image::make($image)->save($folder . $name);
            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
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

        $data = DBImage::findOrFail($request->id);

        $existingImagePath = 'public/' . $data->base_path . $data->name;

        return $existingImagePath;

        return Storage::disk('public')->exists('public/' . $existingImagePath);

        if ($request->id != 'undefined') {
            $data = DBImage::findOrFail($request->id);
            $existingImagePath =  $data->base_path . $data->name;
            return Storage::disk('public')->exists($existingImagePath);


            if (Storage::disk('public')->exists($existingImagePath)) {

                return Storage::disk('public')->delete($existingImagePath);
            }
        }

        // $image = $request->file('image');
        // if ($image) {
        //     $folder = 'assets/images/banner/home/';
        //     $name = time() . '_' . $request->image->getClientOriginalName();

        //     $result = Image::make($image)->save($folder . $name);

        //     $Imagefile = DBImage::updateOrCreate([
        //         'name' => $name,
        //         'base_url' => $request->root(),
        //         'base_path' => $folder,
        //     ]);
        //     if ($Imagefile->save()) {
        //         return response()->json([
        //             'success' => true,
        //             'data' => $Imagefile
        //         ]);
        //     }
        // }
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
            $folder = 'assets/images/banner/';
            $name = time() . '_' . $request->image->getClientOriginalName();
            $result = Image::make($image)->save($folder . $name);
            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
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
            $folder = 'assets/images/faq_category/';
            $name = time() . '_' . $request->image->getClientOriginalName();

            $result = Image::make($image)->save($folder . $name);

            $Imagefile = DBImage::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
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
