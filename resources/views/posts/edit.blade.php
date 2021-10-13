@extends('layouts.app')
@section('content')
    <h1>add new post</h1>
    <form method="POST" action="{{route('posts.update',['post' => $post->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('posts.form')
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-block">update</button>
        </div>
    </form>
@endsection
