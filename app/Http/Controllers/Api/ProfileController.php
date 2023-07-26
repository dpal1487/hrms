<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Item;
use App\Models\UserReview;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\ItemResource;
use App\Http\Resources\Api\UserResource;

class ProfileController extends Controller
{
  public function index($id)
  {
    $user = User::find($id);
    $items = Item::where('user_id', $id)->orderBy('id','desc');
    $reviews = UserReview::where(['user_id' => $id]);
    return [
      'user' => new UserResource($user),
      'items' => ItemResource::collection($items->get()),
    ];
  }
 
}
