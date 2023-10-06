<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        // return $request;
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // return Auth::guard('admin')->attempt($credentials);

        if ($user = Auth::guard('admin')->attempt($credentials)) {
            return redirect('/dashboard')->with('flash', ['message' => 'Successfully login']);
        }
        return back()->withErrors(['message' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
