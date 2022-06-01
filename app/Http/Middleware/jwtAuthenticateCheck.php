<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class jwtAuthenticateCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                $token = JWTAuth::parseToken();
                JWTAuth::toUser($token);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                //throw an exception
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                //throw an exception
            } else if ( $e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
                //throw an exception
            }else{
                //throw an exception
            }
        }
        return $next($request);
    }
}
