<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Undocumented function
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::query()
            ->where('id', Auth::id())
            ->first();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user->delete();
        return redirect()->route('index');
    }
}
