<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class AuthToken
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
        $appToken = env('AUTH_TOKEN');
        $token = $request->headers->get('auth-token');
        if ($appToken && $appToken === $token) {
            return $next($request);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
