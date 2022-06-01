<?php

namespace App\Http\Middleware;

use Closure;

class IncreasePostSize
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
        ini_set("upload_max_filesize", "200M");
        ini_set("post_max_size", "200M");
        
        return $next($request);
    }
}
