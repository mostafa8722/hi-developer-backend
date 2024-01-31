<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanelUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {




        $user = User::whereApi_token(trim($request->bearerToken()))->first();

    if(!$user)
            return  response([
                "data"=>"دسترسی شما مجاز نمی باشد ",
                "status" =>403
            ],403);
        return $next($request);
    }
}
