<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public function posts(){
        return $this->morphedByMany(Post::class,'taggable')->withTimestamps();
    }

    public function comments(){
        return $this->morphedByMany(Comment::class,'taggable')->withTimestamps();
    }
}
