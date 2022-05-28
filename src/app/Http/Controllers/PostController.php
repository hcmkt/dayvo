<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::query()
            ->where('user_id', Auth::id())
            ->latest('date')
            ->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('posts.edit', date('Y-m-d'));
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\PostStoreRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostStoreRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'body' => $request->body,
        ]);
        foreach ((array)$request->tag_ids as $tag_id) {
            try {
                $post->tags()->attach($tag_id);
            } catch (Exception $e) {
                //
            }
        }
        $request->session()->regenerateToken();
        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  string  $date
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($date)
    {
        if ($is_valid_date = preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            list($y, $m, $d) = explode('-', $date);
            $is_valid_date = checkdate($m, $d, $y);
        }
        if (!$is_valid_date) {
            return redirect()->route('posts.index');
        }
        $post = Post::query()
            ->where('user_id', Auth::id())
            ->where('date', $date)
            ->first();
        $tags = Tag::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified post in storage.
     *
     * @param  App\Http\Requests\PostUpdateRequest  $request
     * @param  string  $date
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $date)
    {
        $post = Post::query()
            ->where('user_id', Auth::id())
            ->where('date', $date)
            ->first();
        $post->update([
            'body' => $request->body,
        ]);
        $tags = Tag::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();
        foreach ($tags as $tag) {
            if (in_array($tag->id, (array)$request->tag_ids)) {
                try {
                    $post->tags()->attach($tag->id);
                } catch (Exception $e) {
                    //
                }
            } else {
                try {
                    $post->tags()->detach($tag->id);
                } catch (Exception $e) {
                    //
                }
            }
        }
        $request->session()->regenerateToken();
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  string  $date
     * @return \Illuminate\Http\Response
     */
    public function destroy($date)
    {
        $post = Post::query()
            ->where('user_id', Auth::id())
            ->where('date', $date)
            ->first();
        $post->delete();
        return redirect()->route('posts.index');
    }
}
