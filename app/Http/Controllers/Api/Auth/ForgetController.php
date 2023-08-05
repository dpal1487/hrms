<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgetController extends Controller
{
    public function forget(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->first()
            ], 400);
        }

        $response = $this->broker()->sendResetLink($request->only('email'));

        // return    Password::sendResetLink($request->only('email'));

        // return Password::RESET_LINK_SENT;

        // return $response;
        if ($response === Password::RESET_LINK_SENT) {
            return redirect()->route('password.forgot')->with('status', trans($response));
        } elseif ($response === Password::INVALID_USER) {
            return back()->withErrors(['email' => trans($response)]);
        } else {
            return response()->json(['email' => ErrorMessage()]);
        }
    }

    protected function broker()
    {
        return Password::broker();
    }
}
