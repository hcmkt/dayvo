<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialAccount;

class SocialAccountController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param App\Models\SocialAccount  $social_account
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SocialAccount $social_account) 
    {
        $social_account->delete();
        return redirect()->route('settings');
    }
}
