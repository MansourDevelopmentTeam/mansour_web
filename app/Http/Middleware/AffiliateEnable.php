<?php

namespace App\Http\Middleware;

use Closure;


class AffiliateEnable
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
        

        if (!config('constants.enable_affiliate')) {
            return response()->json([
                "code" => 422,
                "message" => "Affiliates Is Disabled"
            ], 200);
        }
        return $next($request);
    }
}
