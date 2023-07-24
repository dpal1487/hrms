<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Http\Resources\Api\UserProfile;
use App\Http\Resources\Api\Items;

class UserController extends Controller
{
    public function index(Request $request , $id){
        return [
            'data'=>new UserProfile(User::find($id))
        ];
    }
    public function items(Request $request){
        $items = Item::orderBy('id','desc')->get();
        return Items::collection($items);   
    }
     public function getReviews($id)
      {
        $reviews = UserReview::where(['user_id' => $id])->get();
        return [
          'reviews' => Reviews::collection($reviews),
          'user' => new Users(User::find($id)),
        ];
      }
      public function follow(Request $request)
      {
        if ($user = User::where(['id' => $request->uid])->first()) {
          if ($request->id != $this->uid()) {
            if (!Follower::where(['follower_id' => $this->uid(), 'following_id' => $request->uid])->first()) {
              if (Follower::create(['following_id' => $request->uid, 'follower_id' => $this->uid()])) {
                return response()->json([
                  'message' => "Your now start Following $user->first_name $user->last_name",
                  'success' => true
                ]);
              }
            } else {
              if (Follower::where(['following_id' => $request->uid, 'follower_id' => $this->uid()])->delete()) {
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