<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
        //Crean token

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['user' => new UserResource($user), 'success' => true])->withCookie(cookie('api_token', $token, 60 * 24));;
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    public function logout(Request $request)
    {

        return "sadsdfd";
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'])->withCookie(cookie('auth_token', null));
    }
    public function user()
    {
        return response()->json(['data' => auth()->user(), 'success' => true]);
    }
}
