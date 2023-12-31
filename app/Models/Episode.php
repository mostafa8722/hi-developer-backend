<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        "course_id",
        "user_id",
        "type",
        "title",
        "slug",
        "abstract",
        "body",
        "videoUrl",
        "tags",
        "time",
        "time_published",
        "number",
        "viewCount",
        "commentCount",
        "downloadCount",
        "status"

    ];
    protected $casts = [

        "tags"=> 'array',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function path(){
        return "courses/{$this->course->id}/episode/{$this->number}";
    }
}
