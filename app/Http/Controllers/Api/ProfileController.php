<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\ItemResource;
use App\Http\Resources\Api\UserProfileResource;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Profile\Profile;
use App\Http\Resources\Profile\Reviews;
use App\Http\Resources\Users;
use App\Http\Resources\Items;
use App\Http\Resources\Web\ReviewResource;
use App\Models\Follower;
use App\Models\User;
use App\Models\Item;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use JWTAuth;

class ProfileController extends Controller
{
  public function index($id)
  {
    $user = User::find($id);
    $items = Item::where('user_id', $id)->orderBy('id', 'desc');
    $reviews = UserReview::where(['user_id' => $id]);
    return [
      'user' => new UserResource($user),
      'items' => ItemResource::collection($items->get()),
    ];
  }
  public function getReviews($id)
  {
    $reviews = UserReview::where(['user_id' => $id])->get();
    return [
      'reviews' => ReviewResource::collection($reviews),
      'user' => new UserProfileResource(User::find($id)),
    ];
  }
  public function follow(Request $request)
  {
    if ($user = User::where(['id' => $request->id])->first()) {
      if ($request->id != $this->uid()) {
        if (!Follower::where(['follower_id' => $this->uid(), 'following_id' => $request->id])->first()) {
          if (Follower::create(['following_id' => $request->id, 'follower_id' => $this->uid()])) {
            return response()->json([
              'message' => "Your now start Following $user->first_name $user->last_name",
              'success' => true
            ]);
          }
        } else {
          if (Follower::where(['following_id' => $request->id, 'follower_id' => $this->uid()])->delete()) {
            return response()->json([
              'message' => "Your now Unfollow $user->first_name $user->last_name",
              'success' => true
            ]);
          }
        }
      } else {
        return response()->json(['success' => false, 'message' => "You can't be follow yourself."], 400);
      }
    }
    return response()->json(['success' => false, 'message' => "Faild to Following."], 400);
  }
}
