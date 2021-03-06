<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsClient
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
        if (Auth::check() &&  Auth::user()->role_id === 2) {
            return $next($request);
        }
        
        return redirect('/');
    }
}
