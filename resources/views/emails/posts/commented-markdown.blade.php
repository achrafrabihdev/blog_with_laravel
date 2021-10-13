@component('mail::message')
# Introduction

Someone has comment you Post

[go to koora](https://www.kooora.com)

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id])])
{{$comment->commentable->title}}
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id])])
{{ $comment->user->name }} Said :
@endcomponent

@component('mail::panel')
{{ $comment->content }}.
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

