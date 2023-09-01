<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

        if ($admin = Auth::guard('admin')->attempt($credentials)) {
            if ($admin == 1) {
                return redirect('/dashboard')->with('flash', ['message' => 'Admin Successfully login']);
            }
            return back()->withErrors(['message' => 'Invalid credentials.']);
        } else if ($user = Auth::guard('web')->attempt($credentials)) {
            if ($user == 1) {
                return redirect('/dashboard')->with('flash', ['message' => 'User Successfully login']);
            }
            return back()->withErrors(['message' => 'Invalid credentials.']);
        }
        return back()->withErrors(['message' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
