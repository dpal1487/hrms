<?php

namespace App\Http\Controllers\Api\Account;


use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MyAds\Reviews;
use App\Models\Item;
use App\Models\ItemReview;

class AdReviewController extends Controller
{
  public function index($id)
  {
    $item = Item::select('*')->where('id',$id)->where('user_id',$this->uid())->first();
    if($item)
    {
      return Reviews::collection($item->reviews);
    }
    return response()->json(['data'=>null]);
  }
  public function report(){

  }
}
