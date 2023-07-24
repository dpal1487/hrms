<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\Follower;
use App\Models\Item;

class AccountController extends Controller
{
  public function index()
  {
    $user = User::where('id', $this->uid())->first();
    return [
        'user'=>new UserResource($user),
        'data'=>[
            'posts'=>Item::where(['user_id'=>$this->uid()])->count(),
            'follower'=>Follower::where('following_id',$this->uid())->count(),
            'following'=>Follower::where('follower_id',$this->uid())->count(),
        ]
    ];
  }
  public function update(Request $request)
  {
    //Validate data
    $validator = Validator::make($request->all(), [
      'first_name' => 'required|string',
      'last_name' => 'required|string',
      'gender' => 'required',
      'date_of_birth' => 'required',
      'about' => 'required|string'
    ]);
    //Send failed response if request is not valid
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], 201);
    }
    //Request is valid, create new user
    if (User::where(['id' => $this->uid()])->update([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'gender' => $request->gender,
      'date_of_birth' => $request->date_of_birth,
      'about' => $request->about
    ])) {
      return response()->json([
        'success' => true,
        'message' => 'Account Details Updated!',
      ], Response::HTTP_OK);
    } else {
      return response()->json([
        'success' => true,
        'message' => 'Failed to update Profile Details',
      ], Response::HTTP_OK);
    }
  }
}