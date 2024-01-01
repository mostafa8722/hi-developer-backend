<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Image;


class AdminController extends Controller
{
    public function uploadFile($file,$type,$filename){


        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;

        $path = "/uploads/files/{$type}/{$year}/{$month}/{$day}/";
        $file->getClientOriginalName();
        $file->move(public_path($path),$filename);

        return $path.$filename;

    }
    public  function validEmail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }
    protected function uploadImages($file,$type,$filename){


        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        // $imagePath = "/uploads/users/";

        $path = "/uploads/files/{$type}/{$year}/{$month}/{$day}/";

        $file->getClientOriginalName();
        $file = $file->move(public_path($path),$filename);

        $sizes = ["100","200","300"];
        $url["images"] = $this->resize($file->getRealPath(),$sizes,$path,$filename);
        $url["thumb"] = $url["images"][$sizes[0]];



        return $url;

    }
    public function resize($path,$sizes,$imagePath,$filename){


        foreach ($sizes as $size){

            $images["orginal"]= $imagePath.$filename;

            $images[$size] = $imagePath."{$size}_".$filename ;

            Image::make($path)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($images[$size]));
        }
        return $images;

    }
    public  function setCoutrseTime($episode){
        $course = $episode->course;
        $course->time = $this->getCourseTimes($course->episodes->pluck("time"));
        $course->save();
    }

    public function getCourseTimes($times){
        $timeStamp = Carbon::parse("00:00:00");
        foreach ($times as $t){
            $time = strtotime(strlen($t) ===5?"00:".$t:$t) ;

            $timeStamp->addSecond($time);
        }
        return $timeStamp->format("H:i:s");
    }

    public function getUserIpAddr(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
