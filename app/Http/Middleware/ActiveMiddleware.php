<?php

namespace App\Http\Middleware;

use Closure;

class ActiveMiddleware
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
        $user = $request->user();
        if (!$user || !$user->active) {
            return response()->json(['message'=>'Unauthorized acceess', "code" => 401, "error" => "not verified"], 200);
        }

        return $next($request);
    }
}
