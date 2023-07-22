<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
class SettingController extends Controller
{
  public function updatePassword(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'current_password' => 'required|min:4',
      'new_password' => 'required|min:4',
      'confirm_password' => 'required|min:4|same:new_password'
    ]);
    if ($validation->fails()) {
      return response()->json(['success' => false, 'message' => $validation->errors()->first()], 400);
    } else {
      if ($user = User::where(['id' => $this->uid()])->first()) {
        if (Hash::check($request->current_password, $user->password)) {
          if (User::where('id', $this->uid())->update(['password' => Hash::make($request->get('new_password'))])) {
            return response()->json(['success' => true, 'message' => 'Your password has been changed successfully']);
          } else {
            return response()->json(['success' => false, 'message' => 'Something went worng. Try again'],400);
          }
        }
        return response()->json(['success' => false, 'message' => 'Please enter valid current password.'],400);
      } else {
        return response()->json(['success' => false, 'message' => 'Something went worng. Try again'],400);
      }
    }
  }
  public function deactivate(Request $request)
  {
    if (User::where(['id' => $this->getTokenId()])->update(['status' => 0])) {
      return response()->json(['message' => 'Your account has been deactivated.', 'success' => true]);
    }
    return $this->errorMessage();
  }
}
