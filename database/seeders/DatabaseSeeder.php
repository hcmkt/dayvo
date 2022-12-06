<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $num_users = 10;
        $num_social_account_per_user = 2;
        $num_posts_per_user = 4;
        $num_tags_per_user = 3;
        $num_post_tag_trial = floor(0.5 * ($num_posts_per_user+1) * ($num_tags_per_user+1));

        while (true) {
            try {
                User::factory()
                    ->count($num_users)
                    ->hasSocialAccounts($num_social_account_per_user)
                    ->hasPosts($num_posts_per_user)
                    ->hasTags($num_tags_per_user)
                    ->create();
                break;
            } catch (QueryException) {
                //
            }
        }
        
        foreach (User::all()->pluck('id') as $id) {
            $post_id = Post::where('user_id', $id)->pluck('id')->push(null);
            $tag_id = Tag::where('user_id', $id)->pluck('id')->push(null);
            $mix_id = $post_id->crossJoin($tag_id)->shuffle();
            for ($i=0; $i<$num_post_tag_trial; $i++) {
                $comb_id = $mix_id->pop();
                if (in_array(null, $comb_id)) {
                    continue;
                }
                $post = Post::find($comb_id[0]);
                $post->tags()->attach($comb_id[1]);
            }
        }
    }
}
