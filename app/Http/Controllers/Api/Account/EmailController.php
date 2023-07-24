<?php

namespace App\Http\Controllers\Api\Account;


use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Mail\ChangeEmail;
use App\Models\User;
use Mail;
use Str;
use Hash;

class EmailController extends Controller
{
  public function sendOtp(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'email' => 'required|string',
    ]);
    if ($validation->fails()) {
      return response()->json(['success' => false, 'message' => $validation->errors()->first()], 200);
    } else {
      $string = rand(111111, 999999);
      $email = $request->email;
      $title = 'Rhentu Account - ' . $string . ' is your verification code for secure access';
      $customer_details = ['otp' => $string, 'email' => $email];
      $sendmail = Mail::to($customer_details['email'])->send(new ChangeEmail($title, $customer_details));
      if (!User::where(['id' => $this->uid(), 'email' => $request->email])->first()) {
        if ($sendmail) {
          if (User::where('id', $this->uid())->update(['reset_otp' => $string])) {
            return response()->json(['success' => true, 'message' => 'OTP successfully sent to ' . $email]);
          } else {
            return $this->errorMessage();
          }
        } else {
          return $this->errorMessage();
        }
      }
      return response()->json(['success' => false, 'message' => 'Please use different email address'],400);
    }
  }
  public function verifyOtp(Request $request)
  {
   
    $validation = Validator::make($request->all(), [
      'otp_number' => 'required|numeric|min:4',
      'email' => 'required|string',
      'password' => 'required'
    ]);
    if ($validation->fails()) {
      return response()->json(['success' => false, 'message' => $validation->errors()->first()]);
    } else {
      if (User::where(['id' =>  $this->uid(), 'reset_otp' => $request->otp_number])->first()) {
        if ($user = User::where(['id' =>  $this->uid()])->first()) {
          if (Hash::check($request->password, $user->password)) {
            if (User::where(['email' => $request->email])->update(['email' => null])) {
              if (User::where('id',  $this->uid())->update(['email' => strtolower($request->email), 'reset_otp' => 0])) {
                return response()->json(['success' => true, 'message' => 'Your email address has been updated successfully']);
              }
            }
          }
          return response()->json(['success' => false, 'message' => 'Please enter valid password']);
        }
      } else {
        return response()->json(['success' => false, 'message' => 'Incorrect verification code']);
      }
    }
    return $this->errorMessage();
  }
}