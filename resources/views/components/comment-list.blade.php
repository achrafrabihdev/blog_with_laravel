@forelse($comments as $comment)
<p>
    {{ $comment->content }}
</p>
<div class="text-muted">
    <x-updated :date="$comment->updated_at" :name="$comment->user->name" :user-id="$comment->user->id"> </x-updated>
</div>
@empty
<p>No comments yet!</p>
@endforelse
