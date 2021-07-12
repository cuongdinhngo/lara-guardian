<?php

namespace App\Http\Middleware;

use Closure;

class GuardianMiddleware
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
        $user = auth()->user();
        if ($user && $user->rightAccess()) {
            return $next($request);
        }
        throw new \Exception('No Permission');
    }
}
