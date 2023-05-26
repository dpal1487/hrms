<?php

namespace App\Http\Controllers;

use Image;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Address;
use App\Models\Country;
use App\Models\Employee;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AddressResource;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Validator;


class MyAccountController extends Controller
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

    public function overview()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if ($user->address) {
            return Inertia::render(
                'User/Overview',
                [
                    'user' => new UserResource($user),
                    'address' => new AddressResource($user->address),

                ]
            );
        } else {
            return Inertia::render(
                'User/Overview',
                [
                    'user' => new UserResource($user),
                ]
            );
        }
        return redirect()->back();
    }
    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'unique:plans,slug',
            'date_of_birth' => 'required',
            'dark_mode' => 'required',
            'gender' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        $user = User::where('id', Auth::user()->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'dark_mode' => $request->dark_mode,
            'gender' => $request->gender,
        ]);
        if ($user) {
            return redirect("/account")->with('flash', ['message' => 'Account successfully updated.']);
        }
        return redirect()->back()->withErrors(['Opps something went wrong!']);
    }
    public function setting()
    {
        $user = User::where('id', Auth::user()->id)->first();
        if ($user->address) {
            return Inertia::render('User/Setting', [
                'user' => new UserResource($user),
                'address' => new AddressResource($user->address),
            ]);
        } else {
            return Inertia::render('User/Setting', [
                'user' => new UserResource($user),
            ]);
        }
    }

    public function emailUpdate(Request $request)
    {

        if ($request->ajax()) {
            if ($request->confirm_password == null) {
                return redirect()->back()->withErrors(['message' => "Please Insert password!"]);
            }
            $validator =  Validator::make($request->all(), [
                'email' => 'required|unique:users,email',
            ]);
            if ($validator->fails()) {

                return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
            }
            if (Hash::check($request->confirm_password, Auth::user()->password)) {
                $userEmail = User::where('id', Auth::user()->id)->update([
                    'email' => $request->email,
                ]);
                if ($userEmail) {
                    return redirect("/account/setting")->with('flash', ['message' => 'Account successfully updated.']);
                }
            }
            return redirect()->back()->withErrors(['message' => "Don't Have Autherity To change Email! Please insert correct password!"]);
        } else {
            return $this->errorAjax();
        }
    }

    public function changePassword(Request $request)
    {
        if ($request->ajax()) {
            $validator =  Validator::make($request->all(), [
                'new_password' => 'required',
                'old_password' => 'required',
                'confirm_password' => 'required',
            ]);
            if ($validator->fails()) {

                return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
            }
            $id = Auth::user()->id;
            $user = User::where('id', $id)->first();
            if (strcmp($request->old_password, $user->password == 1)) {
                User::where('id', $id)->update([
                    'password' => Hash::make($request->new_password),
                ]);
                return redirect("/account/setting")->with('flash', ['message' => 'Password changed successfully!']);
            } else {
                return redirect()->back()->withErrors(['message' => "Old Password Doesn't match!"]);
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
        return response()->json(['success' => true, 'message' => "Don't Have Autherity To Deactivate"]);
    }


    public function address()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $countries = Country::get();
        if ($user->address != null) {
            return Inertia::render('User/Address', [
                'address' => new AddressResource($user?->address),
                'user' => new UserResource($user),
                'countries' => CountryResource::collection($countries),
            ]);
        } else {
            return Inertia::render('User/Address', [
                'user' => new UserResource($user),
                'countries' => CountryResource::collection($countries),

            ]);
        }
        return redirect()->back();
    }

    public function updateAddress(Request $request)
    {
        $address = [];
        $validator =  Validator::make($request->all(), [

            'address_line_1' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required',
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors(['message' => $validator->errors()->first()]);
        }
        if (User::where(['id' => Auth::user()->id])->first()) {
            if ($address = UserAddress::where(['user_id' => Auth::user()->id])->first()) {
                $address = Address::where(['id' => $address->address_id])->update([
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country_id' => $request->country,
                    'pincode' => $request->pincode,
                    'is_primary' => $request->is_primary ? 1 : 0,
                ]);
                if ($address) {
                    return redirect("/account/address")->with('flash', ['message' => 'Address successfully updated.']);
                }
            }
            return redirect()->back()->withErrors(['Opps something went wrong!']);
        }
        return redirect()->back();
    }
}
