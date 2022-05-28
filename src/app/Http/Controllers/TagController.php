<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Store a newly created tag in storage.
     *
     * @param \App\Http\Requests\TagRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagRequest $request)
    {
        Tag::firstOrcreate([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);
        return redirect()->route('settings');
    }

    /**
     * Update the specified tag in storage.
     *
     * @param \App\Http\Requests\TagRequest  $request
     * @param \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);
        return redirect()->route('settings');
    }
    
    /**
     * Remove the specified tag from storage.
     *
     * @param \App\Models\Tag  $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('settings');
    }
}
