<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceSSL
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

        $domain = $request->root();
        if (!$request->secure() && strpos($domain,"mstball.com") !== false) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
     }
}
