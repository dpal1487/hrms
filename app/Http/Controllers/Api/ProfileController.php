<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Profile\Profile;
use App\Http\Resources\Api\Profile\Reviews;
use App\Http\Resources\Api\Users;
use App\Http\Resources\Items;
use App\Models\Follower;
use App\Models\User;
use App\Models\Item;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use JWTAuth;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
  public function index($id)
  {
    $user = User::find($id);
    $items = Item::where('user_id', $id)->orderBy('id','desc');
    $reviews = UserReview::where(['user_id' => $id]);
    return [
      'user' => new Users($user),
      'items' => Items::collection($items->get()),
    ];
  }
 
}
