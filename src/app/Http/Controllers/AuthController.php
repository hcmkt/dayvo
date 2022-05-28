<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialAccount;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Redirect to Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authRedirect()
    {
        session(['user_id' => Auth::id()]);
        return Socialite::driver('google')
            ->with(['approval_prompt' => 'force'])
            ->redirect();
    }

    /**
     * Log in to service or add google account.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();
        if ($request->session()->has('user_id')) {
            $user_id = $request->session()->pull('user_id');
            if (SocialAccount::where('provider_id', $googleUser->id)->exists()) {
                return redirect()->route('accounterror');
            } else {
                SocialAccount::create([
                    'user_id' => $user_id,
                    'provider_id' => $googleUser->id,
                    'email' => $googleUser->email,
                ]);
                return redirect()->route('settings');
            }
        } else {
            if (SocialAccount::where('provider_id', $googleUser->id)->exists()) {
                $socialAccount = SocialAccount::query()
                    ->where('provider_id', $googleUser->id)
                    ->first();
                $socialAccount->update([
                    'email' => $googleUser->email,
                ]);
                $user = User::query()
                    ->where('id', $socialAccount->user_id)
                    ->first();
            } else {
                $user = User::create();
                SocialAccount::create([
                    'user_id' => $user->id,
                    'provider_id' => $googleUser->id,
                    'email' => $googleUser->email,
                ]);
            }
            Auth::login($user, true);
            return redirect()->route('posts.index');
        }
    }

    /**
     * Logout from service.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
