<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ["title", "abstract","body","type","slug","images","tags","viewCount","commentCount","likeCount","time","status","price","category_id","user_id"];


    protected $casts = [
        "images"=> 'array',
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

    public function user(){
        return $this->belongsTo(User::class);
    }
    public  function category(){
        return $this->belongsTo(Category::class);
    }
    public  function episodes(){
        return $this->hasMany(Episode::class);
    }
    public  function likes(){
        return $this->hasMany(Like::class);
    }
}
