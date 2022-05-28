<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Tag;

class SearchController extends Controller
{
    /**
     * Display a listing of the posts that meet the requirements.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $latest = true;
        $tags = [];
        $ys = [];
        $ms = [];
        $ds = [];
        $words = [];
        $keywords = self::extraceKeywords($request->q);
        foreach ($keywords as $keyword) {
            if ($keyword === '!') $latest = false;
            else if ($keyword[0] === '#') $tags[] = substr($keyword, 1);
            else if (substr($keyword, 0, 2) === 'y:') $ys[] = substr($keyword, 2);
            else if (substr($keyword, 0, 2) === 'm:') $ms[] = substr($keyword, 2);
            else if (substr($keyword, 0, 2) === 'd:') $ds[] = substr($keyword, 2);
            else $words[] = $keyword;
        }
        $tags = array_unique($tags);
        $ys = array_unique($ys);
        $ms = array_unique($ms);
        $ds = array_unique($ds);
        if ($request->q === null && substr($request->fullUrl(), -3) !== '?q=') $words[] = null;
        $posts = DB::table('posts')
            ->where('posts.user_id', Auth::id())
            ->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->leftJoin('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->selectRaw('posts.id, posts.user_id, posts.date, posts.body, tags.name');
        if (!empty($tags)) $posts = $posts->whereIn('name', $tags);
        if (!empty($ys)) $posts = $posts->whereRaw('DATE_FORMAT(posts.date, "%Y") in(?)', [implode(', ', $ys)]);
        if (!empty($ms)) $posts = $posts->whereRaw('DATE_FORMAT(posts.date, "%m") in(?)', [implode(', ', $ms)]);
        if (!empty($ds)) $posts = $posts->whereRaw('DATE_FORMAT(posts.date, "%d") in(?)', [implode(', ', $ds)]);
        foreach ($words as $word) {
            $posts = $posts->whereRaw('MATCH (body) AGAINST (? IN BOOLEAN MODE)', [$word]);
        }
        $posts = $posts->get()->pluck('id')->all();
        $post_ids = [];
        if (count($tags) !== 0) {
            foreach (array_count_values($posts) as $post_id => $count) {
                if ($count === count($tags)) {
                    $post_ids[] = $post_id;
                }
            }
        } else {
            $post_ids = array_unique($posts);
        }
        $posts = Post::whereIn('id', $post_ids);
        if ($latest) $posts = $posts->latest('date');
        else $posts = $posts->oldest('date');
        $posts = $posts->get();

        $tags = Tag::query()
            ->where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get();

        return view('search', compact('posts', 'tags'));
    }

    /**
     * Extract keywords from string concatenated with whitespace.
     *
     * @param string|null $input
     * @param integer $limit
     * @return array
     */
    private static function extraceKeywords(?string $input, int $limit = -1): array
    {
        return array_values(array_unique(preg_split('/[\p{Z}\p{Cc}]++/u', $input, $limit, PREG_SPLIT_NO_EMPTY)));
    }
}
