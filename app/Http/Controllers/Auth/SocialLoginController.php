<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirectToAuth($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider)
    {
        try {
            
            $user = Socialite::driver($provider)->user();

            $findUser = User::where([
                'social_id'=> $user->id,
                'social_type'=>$provider
            ])->first();

            if (!$findUser)
            {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make(Str::random(8)),
                    'social_id'=>$user->id,
                    'social_type'=>$provider,
                    'provider_token' => $user->token,
                ]);

                $newUser->cart()->create();

                event(new Registered($user));
                
                Auth::login($newUser);

                return redirect(RouteServiceProvider::HOME);

            }else{

                Auth::login($findUser);

                return redirect(RouteServiceProvider::HOME);
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage(),
            ]);
        }

    }
}
