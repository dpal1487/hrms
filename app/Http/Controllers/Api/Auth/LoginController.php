<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('mobile', 'password');
        //valid credential
        $validator = Validator::make($credentials, [
            'mobile' => 'required|numeric|digits:10',
            'password' => 'required|string|min:8'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        //Request is validated
        $data = $request->validate([
            'mobile' => 'required',
            'password' => 'required|string|min:8'
        ]);
        if (!auth()->attempt($data)) {
            return response(['message' => 'Your mobile number or password is incorrect. Please try again.', 'success' => false]);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::guard('api')->user();
            $token = auth()->user()->tokens()->delete();
            $token = $user->createToken('API Token')->plainTextToken;
            if ($token) {
                return response(['user' => new UserResource($user), 'access_token' => $token, 'success' => true]);
            } else {
                return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !']);
            }
        }

        // if (Auth::attempt($credentials)) {
        //     $user = Auth::user();
        //     $token = $user->createToken('auth_token')->plainTextToken;
        //     $response = response()->json(['user' => new UserResource($user), 'success' => true]);
        //     $cookie = cookie('api_token', $token, 60 * 2);
        //     $response->withCookie($cookie);
        //     return $response;
        // }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function user()
    {
        return response()->json(['data' => new UserResource(auth()->user()), 'success' => true]);
    }
}
