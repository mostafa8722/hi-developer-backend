<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//
//    $user=\App\Models\User::first();
//    $user->update([
//        "verifyCode"=>rand(100000,999999)
//    ]);
    return  response([
        "data"=>\App\Models\User::get(),
        "data2"=>\Illuminate\Support\Facades\DB::table('categories')->count(),
        "status" =>200
    ],200);

    return Carbon::now();
    return rand(100000,999999);
});

