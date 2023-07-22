<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Craftsys\Msg91\Facade\Msg91;
use Hash;
class RegisterController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'email' => 'unique:users,email',
            'password' => 'required',
            'mobile' => 'required|numeric|unique:users,mobile',
        ]);
        if($validator->fails()){
            return response()->json(['success'=>false,'message'=>$validator->errors()->first()], 400);
        }
        else
        {
            //  $response = Msg91::otp()
            // ->to($request->mobile) // phone number with country code
            // ->template('617ec7f1988e5f7ebb3c7b42') // set the otp template
            // ->send();
            // if($response['type']=='success')
            if(true)
            {
                return response()->json(['success'=>true,'message'=>'OTP is sent to your mobile number.']);
            }
            else
            {
                return response()->json(['success' => false,'message'=>$response['message']]);
            }
        }
    }
    public function verify(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'password' => 'required',
            'otp_number' => 'required|numeric',
            'mobile' => 'required|numeric|min:10|unique:users,mobile',
        ]);
        if($validator->fails()){
            return response()->json(['success'=>false,'type'=>'error','message'=>$validator->errors()->first()]);
        }
        else
        {
            // $response = Msg91::otp($request->otpNumber) // OTP to be verified
            // ->to($request->mobile) // phone number with country code
            // ->verify();
            // if($response['type']=='success'){
                if(true){
                $user = User::create([
                    'first_name' => $request->first_name,
                    'country_code' => '+91',
                    'mobile' => $request->mobile,
                    'image_id' => 1,
                    'password' => Hash::make($request->get('password'))
                ]);
                if($user)
                {
                    $user = User::create($request->toArray());
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    if($token){
                        return response(['user' => auth()->user(), 'access_token' => $token,'success'=>true]);
                    }
                    else{
                        return response()->json(['success'=>false,'type'=>'error','message'=>'Opps something went wrong !']);
                    }
                }
                else
                {
                    return response()->json(['success'=>false,'type'=>'error','message'=>'Opps something went wrong !']);
                }
            }
            else
            {
                return response()->json(['success'=>false,'type'=>'error','message'=>$response['message']]);
            }
        }
    }
}
