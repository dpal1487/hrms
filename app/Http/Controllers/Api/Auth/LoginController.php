<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('mobile', 'password');
        //valid credential
        $validator = Validator::make($credentials, [
            'mobile' => 'required',
            'password' => 'required|string|min:8'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        //Request is validated
        //Crean token
        $data = $request->validate([
            'mobile' => 'required',
            'password' => 'required|string|min:8'
        ]);
        if (!auth()->attempt($data)) {
            return response(['message' => 'Your mobile number or password is incorrect. Please try again.', 'success' => false]);
        }
        $token = auth()->user()->createToken('API Token')->accessToken;
        if ($token) {
            return response(['user' => new UserResource(auth()->user()), 'access_token' => $token, 'success' => true]);
        } else {
            return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !']);
        }
    }
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function user()
    {
        return response()->json(['data' => auth()->user(), 'success' => true]);
    }
}
