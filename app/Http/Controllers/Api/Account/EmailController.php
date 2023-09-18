<?php

namespace App\Http\Controllers\Api\Account;


use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Mail\ChangeEmail;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class EmailController extends Controller
{
  public function sendOtp(Request $request)
  {
    $validation = Validator::make($request->all(), [
      'email' => 'required|string',
    ]);
    if ($validation->fails()) {
      return response()->json(['success' => false, 'message' => $validation->errors()->first()], Response::HTTP_BAD_REQUEST);
    } else {
      $string = rand(111111, 999999);
      $email = $request->email;
      $title = 'Rhentu Account - ' . $string . ' is your verification code for secure access';
      $customer_details = ['otp' => $string, 'email' => $email];
      $sendmail = Mail::to($customer_details['email'])->send(new ChangeEmail($title, $customer_details));
      if (!User::where(['id' => $this->uid(), 'email' => $request->email])->first()) {
        if ($sendmail) {
          if (User::where('id', $this->uid())->update(['reset_otp' => $string])) {
            return response()->json(['success' => true, 'message' => 'OTP successfully sent to ' . $email],Response::HTTP_OK);
          } else {
            return $this->errorMessage();
          }
        } else {
          return $this->errorMessage();
        }
      }
      return response()->json(['success' => false, 'message' => 'Please use different email address'],Response::HTTP_BAD_REQUEST);
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
      return response()->json(['success' => false, 'message' => $validation->errors()->first()],Response::HTTP_BAD_REQUEST);
    } else {
    //   if (User::where(['id' =>  $this->uid(), 'reset_otp' => $request->otp_number])->first()) {
        if ($user = User::where(['id' =>  $this->uid()])->first()) {
          if (Hash::check($request->password, $user->password)) {
            if (User::where(['email' => $request->email])->update(['email' => null])) {
              if (User::where('id',  $this->uid())->update(['email' => strtolower($request->email), 'reset_otp' => 0])) {
                return response()->json(['success' => true, 'message' => 'Your email address has been updated successfully'],Response::HTTP_OK);
              }
            }
          }
          return response()->json(['success' => false, 'message' => 'Please enter valid password'],Response::HTTP_BAD_REQUEST);
        }
    //   } else {
    //     return response()->json(['success' => false, 'message' => 'Incorrect verification code'],Response::HTTP_BAD_REQUEST);
    //   }
    }
    return $this->errorMessage();
  }
}
