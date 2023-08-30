<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Web\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    protected $providers = ['github', 'facebook', 'google', 'twitter'];

    public function SocialSignup(Request $request, $provider)
    {
        // dd($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function loginWithSocial($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            // dd($user);
            $isUser = User::where('email', $user->email)->first();
            // dd($isUser);
            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard')->with('flash', ['message' => 'Successfully login']);
            } else {
                $first_name = explode(' ', $user->name)[0];
                if (strpos($first_name, ",") !== false) {
                    $first_name = explode(',',  $first_name)[0] . " " . explode(',',  $first_name)[1];
                }
                $createUser = User::create([
                    'first_name' => $first_name,
                    'last_name' => count(explode(' ', $user->name)) > 1 ? explode(' ', $user->name)[1] : "",
                    'email' => $user->email,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);
                Auth::login($createUser);
                return redirect('/dashboard')->with('flash', ['message' => 'Successfully login']);
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
