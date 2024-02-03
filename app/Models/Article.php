<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ["title","body","abstract","category_id","tags","images", "slug","viewCount","commentCount","likeCount","user_id","status"];
    protected $casts = [
        "images"=> 'array',
        "tags"=> 'array',
    ];

    public  function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function tags(){
        return $this->hasMany(Tag::class);
    }
    public  function likes(){
        return $this->hasMany(Like::class);
    }

}
