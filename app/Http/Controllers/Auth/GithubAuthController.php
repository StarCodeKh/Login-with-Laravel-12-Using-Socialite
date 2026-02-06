<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();

            $user = User::where('provider_id', $githubUser->id)
                ->orWhere('email', $githubUser->email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $githubUser->name ?? $githubUser->nickname,
                    'email'     => $githubUser->email,
                    'provider_id' => $githubUser->id,
                    'provider'  => 'github',
                    'avatar'    => $githubUser->avatar,
                    'password'  => bcrypt(Str::random(24)),
                    'role_name' => 'User',
                    'status'    => 'Active',
                    'join_date' => now(),
                ]);
            } else {
                if (!$user->github_id) {
                    $user->update([
                        'provider_id' => $githubUser->id,
                        'provider'  => 'github',
                    ]);
                }
            }

            $user->update([
                'last_login' => now(),
            ]);

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Exception $e) {
            \Log::error('GitHub OAuth Error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->withErrors('GitHub authentication failed.');
        }
    }
}