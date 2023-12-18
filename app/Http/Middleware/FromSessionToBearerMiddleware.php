<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use Exception;

class FromSessionToBearerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session('token')) {
            $request->headers->set('Authorization', 'Bearer ' . session('token'));

            try {
                JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    session(['token' => auth()->refresh()]);
                    $request->headers->set('Authorization', 'Bearer ' . session('token'));
                }
            }
        }
        return $next($request);
    }
}
