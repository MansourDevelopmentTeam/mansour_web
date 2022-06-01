<?php

namespace App\Http\Middleware;

use Closure;

class DevOnly
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
        if (app()->environment('production')) {
            return response()->json([
                "code" => 403,
                "message" => "Unauthorized Access"
            ], 200);
        }

        return $next($request);
    }
}
