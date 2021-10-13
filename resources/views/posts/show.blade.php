@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-8">
            <h1>{{$post->title}}</h1>
            @if ($post->image)
                <img src="{{$post->image->url()}}" class="mt-3 img-fluid rounded" alt="">
            @endif
            <x-tags :tags="$post->tags"></x-tags>

            <p>{{$post->content}}</p>
            <em>{{$post->created_at->diffforHumans()}}</em>
            <p>Status :
                @if ($post->active)
                    Enabled
                @else
                    Disabled
                @endif
            </p>
            <h2>Comments</h2>
            <x-comment-form :action="route('posts.comments.store',['post' => $post->id])"></x-comment-form>
            <hr>
            <x-comment-list :comments="$post->comments"></x-comment-list>
        </div>
        <div class="col-4">
            @include('posts.sidebar')
        </div>
    </div>
@endsection
