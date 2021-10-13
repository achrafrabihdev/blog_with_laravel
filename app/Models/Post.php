<?php

namespace App\Models;

use App\Models\Tag;
use App\Scopes\LatestScope;
use App\Scopes\AdminShowDeleteScope;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['title','content','slug','active','user_id'];

        public function comments(){
            return $this->morphMany(Comment::class,'commentable')->dernier();
        }

        public function user(){
            return $this->belongsTo(User::class);
        }
        public function image(){
            return $this->morphOne(Image::class,'imageable');
        }

        public function scopeMostCommented(Builder $query){
            return $query->withCount('comments')->orderBy('comments_count','desc');
        }

        public function scopePostWithCommentsUserTags(Builder $query){
            return $query->withCount('comments')->with(['user','tags']);
        }
        public static function boot(){
            static::addGlobalScope(new AdminShowDeleteScope);
            parent::boot();
            static::addGlobalScope(new LatestScope);
        }
        public function tags(){
            return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
        }
}
