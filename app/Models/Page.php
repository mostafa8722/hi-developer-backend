<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = ["user_id","title", "abstract","body","images","tags","slug","status"];


    protected $casts = [
        "images"=> 'array',
        "tags"=> 'array',
    ];
}
