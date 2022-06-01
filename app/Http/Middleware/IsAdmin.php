<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
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
        if ($user->type != 2) {
            return response()->json(['message'=>'Unauthorized acceess', "code" => 401, "error" => ""], 200);
        }

        return $next($request);
    }
}
