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
      'images' => Images::collection($item->images),
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
      'user' => new Users($item->user),
      'visitors' => count($item->visits),
      'customers' => [
        'total_customers'=>count($item->customers),
        'data'=>count($item->customers),
      ],
      'attributes' => Attributes::collection($item->attributes),
      'description' => $item->description,
      'reviews'=>[
        'data'=>Reviews::collection($item->reviews->skip(0)->take(3)),
        'place_rating'=>$this->placeRating($item->reviews)
      ],
      'related'=>$this->related($request)
    ];
  }
  public function itemReviews(Request $request){
    $reviews = ItemReview::where($request->pid);
    $data =['data'=> Reviews::collection($reviews->get()),'totalReviews'=>$reviews->count()];
  }
  public function related($item){
    $related = Item::where('category_id', $item->category_id)->take(20)->get();
    return Items::collection($related);
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
  public function report(){
    
  }
}
