<?php

namespace App\Listeners;

use App\Events\MyCommentPosted;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\NotifyUsersPostWasCommented;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserAboutComment
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MyCommentPosted $event)
    {
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostMarkdown($event->comment));
        NotifyUsersPostWasCommented::dispatch($event->comment);

    }
}
