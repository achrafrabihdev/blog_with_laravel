@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-8">
        <h1>List of cousces</h1>
    <nav class="nav nav-tabs nav-stacked my-5">
    </nav>
    <div class="my-3">
        <h4>{{$posts->count()}} Post(s)</h4>
    </div>
    <ul  class="list-group">
        @forelse ($posts as $p)
            <li class="list-group-item">
                @if ($p->created_at->diffInHours() < 1)
                    <x-badge type="success">New</x-badge>
                @else
                    <x-badge type="dark">Old</x-badge>
                @endif

                @if ($p->image)
                    <img src="{{$p->image->url()}}" class="mt-3 img-fluid rounded" alt="">
                @endif
                <h2><a href="{{route('posts.show',['post'=>$p->id])}}">
                    @if ($p->trashed())
                        <del>
                            {{$p->title}}
                        </del>
                    @else
                             {{$p->title}}
                    @endif
                </a></h2>
                <x-tags :tags="$p->tags"></x-tags>
                <p>{{$p->content}}</p>
                <em>{{$p->created_at}}</em>
                @if ($p->comments_count)
                <div>
                    <span class="badge badge-success">{{$p->comments_count}} comments</span>
                </div>
                @else
                <div>
                    <span class="badge badge-dark">no comments yet</span>
                </div>
                @endif

                <x-updated :date="$p->updated_at" :name="$p->user->name" :user-id="$p->user->id"> </x-updated>
                <x-updated :date="$p->updated_at">Updated</x-updated>
                @can('update', $p)
                    <a href="{{route('posts.edit',['post' => $p->id])}}" class="btn btn-warning btn-sm">Edit</a>
                @endcan

                @cannot('delete',$p)
                   @component('partials.badge',['type' =>'danger'])
                      you can't delete this post !
                   @endcomponent
                @endcannot
                @if(!$p->deleted_at)
                @can('delete', $p)
                    <form method="POST" class="fm-inline" action="{{route('posts.destroy',['post' => $p->id])}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">delete</button>
                    </form>
                @endcan
                @else
                @can('restore', $p)
                    <form method="POST" class="fm-inline" action="{{url('posts/'.$p->id.'/restore')}}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">restore</button>
                    </form>
                @endcan
                @can('forceDelete', $p)
                    <form method="POST" class="fm-inline" action="{{url('posts/'.$p->id.'/forcedelete')}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">force delete</button>
                    </form>
                @endcan
                @endif
            </li>
        @empty
            <p>Not Posts</p>
        @endforelse
    </ul>
    </div>
    <div class="col-4">
        @include('posts.sidebar')
    </div>
</div>
@endsection
