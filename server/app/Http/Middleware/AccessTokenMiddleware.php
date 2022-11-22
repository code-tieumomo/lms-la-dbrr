<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessTokenMiddleware
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
        $rawToken = $request->header('Authorization');

        if ($rawToken === null || str_starts_with($rawToken, 'Bearer ') === false) {
            return response()->json([
                'error' => 'No token provided',
            ], 401);
        } else {
            $request->token = str_replace('Bearer ', '', $rawToken);
        }

        return $next($request);
    }
}
