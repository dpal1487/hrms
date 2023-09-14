<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Controller;
use App\Http\Resources\Api\Account\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('mobile', 'email', 'password');
        $remember = $request->has('remember'); // Check if the remember checkbox is selected
        //valid credential
        $validator = Validator::make($credentials, [
            'mobile' => 'numeric|digits:10',
            'email' => 'email',
            'password' =>  Password::min(8),
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        //Request is validated

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::guard('api')->user();
            $token = auth()->user()->tokens()->delete();
            $token = $user->createToken('api')->plainTextToken;

            return response()->json([
                'user' => new UserResource($user),
                'success' => true,
                'access_token' => $token,
                'message' => 'Successfully login',
            ])->withCookie(cookie('api_token', $token, 60 * 24));
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['access_token' => $user->createToken('api')->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'])->withCookie(cookie('api', null));
    }
    public function user()
    {
        return response()->json(['data' => auth()->user(), 'success' => true]);
    }
}
