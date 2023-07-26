<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\ImageResource;
use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Http\Resources\Images;

class ImageController extends Controller
{
  public function post(Request $request)
  {

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
    return new ImageResource($img);
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
