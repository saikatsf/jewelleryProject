<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class userNotLoggedIn
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
        if ($request->session()->exists('userid')) {
            // user value cannot be found in session
            return redirect('/'); 
        }
        return $next($request);
    }
}
