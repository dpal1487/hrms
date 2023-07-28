<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', 'http://192.168.1.8:3000 , *')
            ->header('Access-Control-Allow-Methods', "PUT, POST, GET, DELETE, OPTIONS")
            ->header('Access-Control-Allow-Headers', "Accept, Authorization, Content-Type")
            ->header('Access-Control-Allow-Credentials', "false");
    }
}
