<x-card title="Most Post Commented">
    @foreach ($mostCommented as $post)
    <li class="list-group-item">
         <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a><br>
         <span class="badge badge-success">{{$post->comments_count}} comments</span>
    </li>
    @endforeach
</x-card>
<x-card
        title="Most Users active"
        text="most users post written"
        :items="collect($mostUsersActive)->pluck('name')" >

</x-card>
<x-card
        title="Most Users active in last month"
        :items="collect($userActiveInLastMonth)->pluck('name')" >
</x-card>
