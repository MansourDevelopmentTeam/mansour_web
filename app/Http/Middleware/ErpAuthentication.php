<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FReq;

class ErpAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (!$request->header('erp-token') && $request->header('erp-token') != $settings->erp_token) {
            return response()->json(['message' => 'Unauthorized acceess', "code" => 401, "error" => "not verified"], 200);
        }
        return $next($request);
    }
}
