<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEpisode extends Model
{
    use HasFactory;
    protected $fillable = ["time_seen","user_id","episode_id"];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function episode(){
        return $this->belongsTo(Episode::class);
    }
}
