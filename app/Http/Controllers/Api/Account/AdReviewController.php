<?php

namespace App\Http\Controllers\Api\Account;


use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\MyAds\ReviewsResource;
use App\Models\Item;
use App\Models\ItemReview;

class AdReviewController extends Controller
{
  public function index($id)
  {
    $item = Item::where(['id' => $id, 'user_id' => $this->uid()])->first();

    if ($item) {
      return ReviewsResource::collection($item->reviews);
    }
    return response()->json(['data' => null]);
  }
  public function report()
  {
  }
}
