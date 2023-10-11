<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;
use Image;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Web\Controller;
use App\Http\Resources\Web\ImageResource;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

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
            $data = ImageModel::findOrFail($request->image_id);
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
            $Imagefile = ImageModel::updateOrCreate([
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
            $data = ImageModel::findOrFail($request->id);
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
            $Imagefile = ImageModel::updateOrCreate([
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
            $data = ImageModel::findOrFail($request->id);
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
            $Imagefile = ImageModel::updateOrCreate([
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
            $data = ImageModel::findOrFail($request->id);
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
            $Imagefile = ImageModel::updateOrCreate([
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
            $data = ImageModel::findOrFail($request->id);
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

            $Imagefile = ImageModel::updateOrCreate([
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

    public function uploadOption(Request $request)
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
            $optimizerChain = OptimizerChainFactory::create();
            $name = $image->hashName();

            $folder = 'assets/images/settings/';
            $image = Image::make($image)->save($folder. 'original/' . $name);
            $optimizerChain->optimize($folder. 'original/'. "{$name}");

            $sizes = [150, 300, 600];

            foreach ($sizes as $size) {
                if (!is_dir("assets/images/settings/{$size}px")) {
                    mkdir(("assets/images/settings/{$size}px"), 0755, true);
                }
                $resizedImage = Image::make($image)->save($folder . 'original/' . $name)->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $resizedImage->save(($folder . "{$size}px/{$name}"));
                $optimizerChain->optimize($folder . "{$size}px/{$name}");
            }
            $Imagefile = ImageModel::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => new ImageResource($Imagefile)
                ]);
            }            
        }
    }
    
    // public function uploadOption(Request $request)
    // {
    //     $image = $request->file('image');
    //     $optimizerChain = OptimizerChainFactory::create();
    //     $name = $image->hashName();
        // $image->move(Storage::disk('local')->path('public/images'), $name);
    //     $optimizerChain->optimize(Storage::disk('local')->path("public/images/{$name}"));
    //     $sizes = ['small', 'medium', 'large'];
    //     foreach ($sizes as $size) {
    //         if (!is_dir(Storage::disk('local')->path("public/images/{$size}"))) {
    //             mkdir(Storage::disk('local')->path("public/images/{$size}"), 0755, true);
    //         }
    //         $resizedImage = Image::make(Storage::disk('local')->path("public/images/{$name}"))->resize($size, null, function ($constraint) {
    //             $constraint->aspectRatio();
    //         });
    //         $resizedImage->save(Storage::disk('local')->path("public/images/{$size}/{$name}"));
    //         $optimizerChain->optimize(Storage::disk('local')->path("public/images/{$size}/{$name}"));
    //     }
    //     if ($image = ImageModel::create([
    //         'name' => $name,
    //         'base_path' => "app/public/images/",
    //         'base_url' =>  storage_path(),
    //     ])) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => new ImageResource($image)
    //         ]);
    //     }
    // }
}
