<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Web\ImageResource;
use Illuminate\Http\Request;
use App\Models\Image as ImageModel;
use App\Models\ItemImage;
use Illuminate\Support\Facades\Storage;
use Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class ImageController extends Controller
{
  public function store(Request $request)
  {
    $image = $request->file('image');
    $optimizerChain = OptimizerChainFactory::create();
    $name = $image->hashName();
    $image->move(Storage::disk('local')->path('images/original'), $name);
    $optimizerChain->optimize(Storage::disk('local')->path("images/original/{$name}"));
    $sizes = [150, 300, 600];
    foreach ($sizes as $size) {
      if (!is_dir(Storage::disk('local')->path("images/{$size}px"))) {
        mkdir(Storage::disk('local')->path("images/{$size}px"), 0755, true);
      }
      $resizedImage = Image::make(Storage::disk('local')->path("images/original/{$name}"))->resize($size, null, function ($constraint) {
        $constraint->aspectRatio();
      });
      $resizedImage->save(Storage::disk('local')->path("images/{$size}px/{$name}"));
      $optimizerChain->optimize(Storage::disk('local')->path("images/{$size}px/{$name}"));
    }
    if ($image = ImageModel::create([
      'name' => $name,
      'base_path' => "storage/app/images/original/",
      'base_url' => $request->url(),
    ])) {
      return new ImageResource($image);
    }
  }
}
