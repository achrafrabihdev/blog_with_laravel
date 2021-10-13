<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
class PostObserver
{
    /**
     * Handle the Post "updating" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        Cache::forget("post-show-{$post->id}");
    }

    /**
     * Handle the Post "deleting" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleting(Post $post)
    {
        $post->comments()->delete();
    }

    /**
     * Handle the Post "restoring" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function restoring(Post $post)
    {
        $post->comments()->restore();
    }
}
