@extends('layouts.app')
@section('content')
    <h1>add new post</h1>
    <form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
        @csrf
        @include('posts.form')

            <button type="submit" class="btn btn-primary btn-block">save</button>
    </form>
@endsection
