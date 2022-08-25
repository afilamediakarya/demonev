<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class hasAccess extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guard)
    {
        if (auth()->check()) {
            if (auth()->user()->hasAkses($guard)) {
                return $next($request);
            }
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }
}
