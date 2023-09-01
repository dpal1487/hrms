<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use \Carbon\Carbon;

class SocialLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function handleCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            // dd($user);
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/dashboard');
            } else {
                $first_name = explode(' ', $user->name)[0];
                if (strpos($first_name, ",") !== false) {
                    $first_name = explode(',',  $first_name)[0] . " " . explode(',',  $first_name)[1];
                }
                $newUser = User::create([
                    'first_name' => $first_name,
                    'last_name' => count(explode(' ', $user->name)) > 1 ? explode(' ', $user->name)[1] : "",
                    'email' => $user->email,
                    'avatar' =>$user->avatar,
                    'social_id' => $user->id,
                    // 'email_verified_at' => $user->user['email_verified'] == true ? Carbon::now() : NULL,
                    'social_type' => $provider,
                    'password' => Hash::make('my-google')
                ]);
                Auth::login($newUser);
                return redirect('/dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
