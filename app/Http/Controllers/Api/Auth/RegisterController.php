<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Validator;
use Craftsys\Msg91\Facade\Msg91;
use Hash;

class RegisterController extends Controller
{


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'unique:users,email',
            'password' => 'required|string|min:8',
            'mobile' => 'required|numeric|unique:users,mobile',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 400);
        } else {
            //  $response = Msg91::otp()
            // ->to($request->mobile) // phone number with country code
            // ->template('617ec7f1988e5f7ebb3c7b42') // set the otp template
            // ->send();
            // if($response['type']=='success')
            if (true) {
                return response()->json(['success' => true, 'message' => 'OTP is sent to your mobile number.']);
            } else {
                return response()->json(['success' => false, 'message' => $response['message']]);
            }
        }
    }
    public function verify(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'otp_number' => 'required|numeric',
            'mobile' => 'required|numeric|min:10|unique:users,mobile',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'type' => 'error', 'message' => $validator->errors()->first()]);
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
                    'last_name' => explode(' ', $request->name)[1] ? explode(' ', $request->name)[1] : "",
                    'country_code' => '+91',
                    'mobile' => $request->mobile,
                    'image_id' => 1,
                    'password' => Hash::make($request->get('password'))
                ]);
                if ($user) {
                    // $user = User::create($request->toArray());
                    $token = $user->createToken('auth_token')->plainTextToken;
                    if ($token) {
                        return response()->json(['user' => $user, 'message' => 'Registerd successfully', 'success' => true])->withCookie(cookie('api_token', $token, 60 * 24)); // Set cookie for 24 hours (adjust as needed);
                    } else {
                        return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !']);
                    }
                } else {
                    return response()->json(['success' => false, 'type' => 'error', 'message' => 'Opps something went wrong !']);
                }
            } else {
                return response()->json(['success' => false, 'type' => 'error', 'message' => $response['message']]);
            }
        }
    }
}
