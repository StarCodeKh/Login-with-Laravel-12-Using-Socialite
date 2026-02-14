<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class FacebookAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes(['email', 'public_profile'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->stateless()->user();

            $email = $facebookUser->email 
                ?? $facebookUser->id . '@facebook-user.local';

            $user = User::where('provider_id', $facebookUser->id)
                ->orWhere('email', $email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name'        => $facebookUser->name ?? 'Facebook User',
                    'email'       => $email,
                    'provider_id' => $facebookUser->id,
                    'provider'    => 'facebook',
                    'avatar'      => $facebookUser->avatar,
                    'password'    => bcrypt(Str::random(24)),
                    'role_name'   => 'User',
                    'status'      => 'Active',
                    'join_date'   => now(),
                ]);
            }

            $user->update([
                'last_login' => now(),
            ]);

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Exception $e) {

            \Log::error('Facebook OAuth Error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->withErrors('Facebook authentication failed.');
        }
    }
}