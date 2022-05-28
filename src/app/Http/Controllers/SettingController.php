<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;
use App\Models\Tag;

class SettingController extends Controller
{
    /**
     * Show the settings.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        $tags = Tag::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
        $social_accounts = SocialAccount::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
        return view('settings.index', compact('tags', 'social_accounts'));
    }
}
