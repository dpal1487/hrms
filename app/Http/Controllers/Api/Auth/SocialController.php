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

    public function SocialSignup($provider)
    {
        // Socialite will pick response data automatic
        $user = Socialite::driver($provider)->redirect();
        // $user = Socialite::driver($provider)->stateless()->redirect();
        return $user;
        return response()->json($user);
    }

    public function loginWithSocial($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $isUser = User::where('provider_id', $user->id)->first();
            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard');
            } else {
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'password' => encrypt('admin@123')
                ]);
                Auth::login($createUser);
                return redirect('/dashboard');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
