<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "parent_id",
        "course_id",
        "episode_id",
        "article_id",
        "comment",
        "status",
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function article(){
        return $this->belongsTo(Article::class);
    }
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function episode(){
        return $this->belongsTo(Episode::class);
    }

}
