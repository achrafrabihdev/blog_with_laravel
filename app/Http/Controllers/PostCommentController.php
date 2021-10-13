<?php

namespace App\Http\Controllers;

use App\Events\MyCommentPosted;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Mail\CommentedPostMarkdown;
use App\Mail\CommentPosted;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(StoreComment $request,Post $post){
       $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' =>$request->user()->id
        ]);
        event(new MyCommentPosted($comment));
        return redirect()->back()->withStatus('Comment was created !!');;
    }
}
