<?php

namespace App\Http\Middleware;

use App\Models\Logs\RequestLog;
use Closure;
use Illuminate\Http\Request;

class LogRequestsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (auth()->user() == null) {
        //     return $next($request);
        // }
        //
        // if ($request->method() != 'GET') {
        //     RequestLog::create([
        //         'user_id'   => optional(auth()->user())->id,
        //         'username'  => optional(auth()->user())->name,
        //         'user_type' => optional(auth()->user())->type_name,
        //         'method'    => $request->method(),
        //         'url'       => $request->path(),
        //         'request'   => json_encode($request->toArray())
        //     ]);
        // }
        return $next($request);
    }
}
