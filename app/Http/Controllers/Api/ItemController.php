<?php


namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\Item\Attributes;
use App\Http\Resources\Api\Item\Reviews;
use App\Http\Resources\Api\Items;
use App\Http\Resources\Api\Images;
use App\Http\Resources\Api\Users;
use App\Models\Item;
use App\Models\ItemReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\AttributesResource;
use App\Http\Resources\Api\ImageResource;
use App\Http\Resources\Api\ItemResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Web\ReviewResource;

class ItemController extends Controller
{
  public function index(Request $request)
  {
    $item = Item::where('id', $request->pid)->first();
    return [
      'id' => $item->id,
      'title' => $item->name,
      'base_url' => $item->base_url,
      'category' => $item->category,
      'slug' => $item->slug,
      'time' => $item->time->title,
      'images' => ImageResource::collection($item->images),
      'rent_price' => $item->rent_price,
      'security_price' => $item->security_price,
      'currency' => '₹',
      'location' => [
        'address' => $item->location->address,
        'pincode' => $item->location->pincode,
        'city' => $item->location->city,
        'state' => $item->location->state,
        'locality' => $item->location->locality,
        'latitude' => $item->location->latitude,
        'longitude' => $item->location->longitude
      ],
      'favourite' => [
        'isFavourite' => $item->isFavourite ? true : false,
        'count' => count($item->favourties)
      ],
      'user' => new UserResource($item->user),
      'visitors' => count($item->visits),
      'customers' => [
        'total_customers' => count($item->customers),
        'data' => count($item->customers),
      ],
      'attributes' => AttributesResource::collection($item->attributes),
      'description' => $item->description,
      'reviews' => [
        'data' => ReviewResource::collection($item->reviews->skip(0)->take(3)),
        'place_rating' => $this->placeRating($item->reviews)
      ],
      'related' => $this->related($request)
    ];
  }
  public function itemReviews(Request $request)
  {
    $reviews = ItemReview::where($request->pid);
    $data = ['data' => ReviewResource::collection($reviews->get()), 'totalReviews' => $reviews->count()];
  }
  public function related(Request $request)
  {
    $related = Item::where('category_id', $request->category_id)->take(20)->get();
    return ItemResource::collection($related);
  }
  public function placeRating($reviews)
  {
    $ratingAverage = 0;
    if (count($reviews) > 0) {
      $ratingValues = [];
      $count = 0;
      foreach ($reviews as $aRating) {
        $ratingValues[] = $aRating->rating;
        $count += $aRating->rating;
      }
      $ratingAverage = collect($ratingValues)->sum() / $reviews->count();
      return array(
        'totalReviews' => count($reviews),
        'average_rating' => round($ratingAverage, 1),
        'ratings' => $count,
      );
    }
    return array(
      'totalReviews' => 0,
      'average_rating' => 0,
      'ratings' => 0,
    );
  }
  public function report($id)
  {
    return $id;
  }
}
