<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
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
        return Socialite::driver($provider)->redirect();
    }

    public function loginWithSocial($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $isUser = User::where('email', $user->email)->orWhere('provider_id', $user->id)->first();
            if ($isUser) {
                Auth::login($isUser);
                return response()->json(['data' => $user]);
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
                return response()->json(['data' => $user]);
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
