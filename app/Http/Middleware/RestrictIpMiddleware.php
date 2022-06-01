<?php

namespace App\Http\Middleware;

use App\Models\Orders\BlackIPList;
use Closure;

class RestrictIpMiddleware
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
        $blackList = BlackIPList::all()->pluck('ip')->toArray();

        if(count($blackList) >= 1 )
        {
            if(in_array(getRealIp(), $blackList))
            {
                \Log::warning("Unauthorized access, IP address was => ".request()->ip);

                return response()->json(['message'=>'Your Ip is blocked right now!', "code" => 400
                    , "error" => "not allowed"], 200);
            }
        }

        return $next($request);
    }
}
