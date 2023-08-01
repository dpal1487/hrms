<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\ImageResource;
use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use App\Models\ItemImage;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
  public function userImage(Request $request)
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
      $folder = "assets/images/$request->destination/";
      $result = Image::make($image)->save($folder . $name);
      $imageFile = ImageModel::updateOrCreate([
        'name' => $name,
        'base_url' => $request->root(),
        'base_path' => $folder,
      ]);
      if ($imageFile) {
        $user = User::where('id', '=', $request->id)->update([
          'image_id' => $imageFile->id,
        ]);
      }
      if ($imageFile->save()) {
        return response()->json([
          'success' => true,
          'data' => $imageFile
        ]);
      }
    }
  }

  public function post(Request $request)
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
      $folder = "assets/images/$request->destination/";
      $result = Image::make($image)->save($folder . $name);
      $imageFile = ItemImage::updateOrCreate([
        'item_id' => $request->id,
        'name' => $name,
        'base_url' => $request->root(),
        'base_path' => $folder,
      ]);
      if ($imageFile->save()) {
        return response()->json([
          'success' => true,
          'message' => "Image saved successfully",
          'data' => $imageFile
        ]);
      }
    }
  }

  public function post1(Request $request)
  {
    return $request;
    $request->validate([
      'image' => ['required', 'max:4028']
    ]);
    $filePath = "images/post/" . $request->file('image')->hashName();
    $image = Image::make($request->file('image'))->resize('', 300, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    })->encode('jpeg', 60);
    Storage::disk('s3')->put($filePath, $image->stream(), 'images');
    $img = ImageModel::create([
      'name' => $filePath,
      'small_path' => Storage::disk('s3')->url($filePath),
      'medium_path' => Storage::disk('s3')->url($filePath),
      'large_path' => Storage::disk('s3')->url($filePath),
    ]);
    return new Images($img);
  }
  public function store(Request $request)
  {
    $request->validate([
      'image' => ['required', 'max:4028']
    ]);
    $filePath = "images/$request->destination/" . $request->file('image')->hashName();
    $image = Image::make($request->file('image'))->resize(300, 300, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    })->encode('jpeg', 60);
    Storage::disk('s3')->put($filePath, $image->stream(), 'images');
    $img = ImageModel::create([
      'name' => $filePath,
      'small_path' => Storage::disk('s3')->url($filePath),
      'medium_path' => Storage::disk('s3')->url($filePath),
      'large_path' => Storage::disk('s3')->url($filePath),
    ]);
    return new ImageResource($img);
  }
}
