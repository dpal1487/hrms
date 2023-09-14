<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use App\Models\Image as DBImage;
use Illuminate\Support\Facades\File;
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
        if ($request->image_id != 'undefined') {
            $data = DBImage::findOrFail($request->image_id);
            $categoryThumbnail = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
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
                
                if ($request->id) {
                    $category = Category::where(['id' => $request->id])->update([
                        'image_id' => $Imagefile->id,
                    ]);
                }
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

        if ($request->id != 'undefined') {
            $data = DBImage::findOrFail($request->id);
            $categoryBanner = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
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
        if ($request->id != 'undefined') {
            $data = DBImage::findOrFail($request->id);
            $bannerImage = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
        }
        $image = $request->file('image');
        if ($image) {
            $folder = 'assets/images/banner/home/';
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
    public function brandImage(Request $request)
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
        if ($request->id != 'undefined') {
            $data = DBImage::findOrFail($request->id);
            $brandImage = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
        }
        $image = $request->file('image');
        if ($image) {
            $folder = 'assets/images/brand/';
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

        if ($request->id != 'undefined') {
            $data = DBImage::findOrFail($request->id);
            $faqsImage = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
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
