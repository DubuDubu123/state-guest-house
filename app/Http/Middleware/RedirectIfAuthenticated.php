<?php

namespace App\Http\Middleware;

use Closure;
use App\Base\Constants\Auth\Role;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        // dd("DFgdfg");
        if (Auth::guard($guard)->check()) {
            // dd(Auth::guard($guard)->user());
            
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
