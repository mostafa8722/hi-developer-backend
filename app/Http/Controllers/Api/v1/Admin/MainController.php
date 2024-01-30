<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public  function validEmail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    public  function validPassword($str) {
        return (!preg_match("/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x]).*$/", $str)) ? FALSE : TRUE;
    }
}
