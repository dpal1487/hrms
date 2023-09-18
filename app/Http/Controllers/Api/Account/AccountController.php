<?php

namespace App\Http\Controllers\Api\Account;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\UserResource;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
class AccountController extends Controller
{
  public function index()
  {
    $user = User::where('id', $this->uid())->first();
    return [
      'data' => new UserResource($user),
      // 'data'=>[
      //     'posts'=>Item::where(['user_id'=>$this->uid()])->count(),
      //     'follower'=>Follower::where('following_id',$this->uid())->count(),
      //     'following'=>Follower::where('follower_id',$this->uid())->count(),
      // ]
    ];
  }
  public function update(Request $request)
  {
    //Validate data
    $validator = Validator::make($request->all(), [
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'gender' => 'required|in:male,female',
      'date_of_birth' => 'required|date_format:d-m-Y|before:today',
      'about' => 'required|string'
    ]);
    //Send failed response if request is not valid
    if ($validator->fails()) {
      return response()->json(['success' => false, 'message' => $validator->errors()->first()], Response::HTTP_BAD_REQUEST);
    }
    //Request is valid, create new user
    $user = User::where(['id' => $this->uid()]);
    if ($user->update([
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'gender' => $request->gender,
      'date_of_birth' => $request->date_of_birth,
      'about' => $request->about
    ])) {
      return response()->json([
        'success' => true,
        'data' => new UserResource($user->first()),
        'message' => 'Account Details Updated!',
      ], Response::HTTP_OK);
    } else {
      return response()->json([
        'success' => true,
        'message' => 'Failed to update Profile Details',
      ], Response::HTTP_BAD_REQUEST);
    }
  }
  public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Store the original image
            $image->storeAs('images', $imageName, 'public');

            // Generate a thumbnail
            $thumbnail = Image::make($image)->fit(100, 100)->encode('jpg');
            $thumbnailName = 'thumbnail_' . $imageName;
            Storage::disk('public')->put('thumbnails/' . $thumbnailName, $thumbnail);

            return response()->json(['message' => 'Image and thumbnail updated successfully']);
        }

        return response()->json(['error' => 'Image not provided'], 400);
    }
}
