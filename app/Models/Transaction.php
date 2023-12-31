<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "course_id",
        "user_id",
        "payment",
        "price",
        "discount",
        "body",
        "transaction_code"
    ];
    public  function  user(){
        return $this->belongsTo(User::class);
    }
    public  function  course(){
        return $this->belongsTo(Course::class);
    }


}
