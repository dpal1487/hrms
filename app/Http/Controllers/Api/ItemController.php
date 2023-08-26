<?php


namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\ItemReview;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\AttributesResource;
use App\Http\Resources\Api\ImageResource;
use App\Http\Resources\Api\ItemResource;
use App\Http\Resources\Api\Account\UserResource;
use App\Http\Resources\Api\ItemLocationResource;
use App\Http\Resources\Api\ReportsResource;
use App\Http\Resources\Web\ReviewResource;
use App\Models\ItemLocation;

class ItemController extends Controller
{
  public function index(Request $request)
  {
    $item = Item::where('id', $request->pid)->first();
    $location = ItemLocation::where('item_id', $request->pid)->first();

    return [
      'items' => new ItemResource($item),   
      'images' => ImageResource::collection($item->images),
      'currency' => '₹',
      'location' => [
        'address_line_1' => $location->address->address_line_1,
        'address_line_2' => $location->address->address_line_2,
        'pincode' => $location->address->pincode,
        'city' => $location->address->city,
        'state' => $location->address->state,
        'locality' => $location->address->locality,
        'latitude' => $location->address->latitude,
        'longitude' => $location->address->longitude
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

  public function getReportsItems($id)
  {
    $report = Report::where(['source_id' => $id, 'type_id' => 5])->get();
    return ReportsResource::collection($report);
  }

  public function report(Request $request, $id)
  {
    $data = array('user_id' => $this->uid(), 'type_id' => 5, 'source_id' => $id);
    $reviews = Report::updateOrCreate($data, $data);
    if ($reviews) {
      return response()->json(['message' => 'Thanks for reporting it. Our team will look into it at the earliest.', 'success' => true]);
    }
    return response()->json(['message' => 'Opps someting went wrong!.', 'success' => false]);
  }
}
