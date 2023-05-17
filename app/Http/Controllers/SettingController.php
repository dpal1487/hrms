<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Image;


class SettingController extends Controller
{

    public function avatarImage(Request $request)
    {
        if ($request->ajax()) {

            if (Auth::user()) {
                $image = $request->file('image');
                if ($image) {
                    $extension = $request->image->extension();
                    $file_path = 'assets/images/users/avatar/';
                    $name = time() . '_' . $request->image->getClientOriginalName();

                    $result = Image::make($image)->save($file_path  . $name);

                    $result->resize(200, 200);

                    $result = $result->save($file_path . $name);

                    $userAvatar = User::where('id', Auth::user()->id)->update([
                        'avatar' => $name,
                        'full_path' => url($file_path . $name),
                    ]);
                    if ($userAvatar) {
                        return response()->json([
                            'success' => true,
                            'data' => $userAvatar,
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Image uploade Fail',

                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Do not have permission to change image'
                ], 400);
            }
        } else {
            return $this->errorAjax();
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'unique:plans,slug',
            'date_of_birth' => 'required',
            'dark_mode' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }

        $user = User::where('id', Auth::user()->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'dark_mode' => $request->dark_mode,
            'gender' => $request->gender,
        ]);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User Profile Updated Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'User not updated'
        ]);
    }
    public function emailUpdate(Request $request)
    {
        if ($request->ajax()) {
            if ($request->confirm_password == null) {
                return response()->json(['success' => false, 'message' => 'Please Insert password']);
            }
            if (Hash::check($request->confirm_password, Auth::user()->password)) {
                $userEmail = User::where('id', Auth::user()->id)->update([
                    'email' => $request->email,
                ]);
                return response()->json(['success' => true, 'message' => 'Successfully Change Email!']);
            }
            return response()->json(['success' => false, 'message' => "Don't Have Autherity To change Email! Please insert correct password"]);
        } else {
            return $this->errorAjax();
        }
    }

    public function changePassword(Request $request)
    {
        if ($request->ajax()) {

            $id = Auth::user()->id;
            $user = User::where('id', $id)->first();

            if (strcmp($request->old_password, $user->password == 1)) {
                User::where('id', $id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                return response()->json(['success' => true, 'message' => 'Password changed successfully!']);
            } else {
                return response()->json(['success' => false, 'message' => "Old Password Doesn't match!"]);
            }
        } else {
            return $this->errorAjax();
        }
    }
    public function deactivate()
    {
        $user = Auth::user()->id;
        if ($user) {
            User::where('id', $user)->update(['status' => 0]);
            return response()->json(['success' => true, 'message' => 'User has been  Deactivating.']);
        }
        return response()->json(['success' => true, 'message' => 'User has been  Deactivating.']);
    }
}
