<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\ReviewsResource;
use App\Models\Item;

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
    return "function not working";
  }
}
