<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminNotLoggedIn
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
        if (!$request->session()->exists('adminid')) {
            // user value cannot be found in session
            return redirect('/adminpanel/signin');
        }
        return $next($request);
    }
}
