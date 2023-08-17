<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|unique:users',
            'password' =>  Password::min(8),
            'mobile' => 'numeric|unique:users,mobile|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'type' => 'error', 'message' => $validator->errors()->first()], 400);
        } else {
            //  $response = Msg91::otp()
            // ->to($request->mobile) // phone number with country code
            // ->template('617ec7f1988e5f7ebb3c7b42') // set the otp template
            // ->send();
            // if($response['type']=='success')
            if (true) {
                if ($request->mobile) {
                    return response()->json(['success' => true, 'message' => 'Enter the 6 digit code sent to you at +91*******' . substr($request->mobile, -3)]);
                }
                if ($request->email) {
                    return response()->json(['success' => true, 'message' => 'Enter the 6 digit code sent to you at ' . substr($request->email, 0, 3) . "*****@" . explode("@", $request->email)[1]]);
                }
            } else {
                // return response()->json(['success' => false, 'message' => $response['message']]);
            }
        }
    }
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' =>  Password::min(8),
            'otp_number' => 'required|numeric',
            'email' => 'email|unique:users',
            'mobile' => 'numeric|min:10|unique:users,mobile|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'type' => 'error', 'message' => $validator->errors()->first()], 400);
        } else {
            // $response = Msg91::otp($request->otpNumber) // OTP to be verified
            // ->to($request->mobile) // phone number with country code
            // ->verify();
            // if($response['type']=='success'){
            if (true) {
                $first_name = explode(' ', $request->name)[0];
                if (strpos($first_name, ",") !== false) {
                    $first_name = explode(',',  $first_name)[0] . " " . explode(',',  $first_name)[1];
                }
                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => count(explode(' ', $request->name)) > 1 ? explode(' ', $request->name)[1] : "",
                    'country_code' => '+91',
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'image_id' => 1,
                    'password' => Hash::make($request->get('password'))
                ]);
                if ($user) {
                    // $user = User::create($request->toArray());
                    $token = $user->createToken('auth_token')->plainTextToken;
                    if ($token) {
                        return response()->json([
                            'user' => $user,
                            'message' => 'Registerd successfully',
                            'success' => true,
                            'access_token' => $token
                        ])->withCookie(cookie('api_token', $token, 60 * 24)); // Set cookie for 24 hours (adjust as needed);
                    } else {
                        return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !'], 400);
                    }
                } else {
                    return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !'], 400);
                }
            } else {
                // return response()->json(['success' => false, 'type' => 'error', 'message' => $response['message']]);
            }
        }
    }
}
