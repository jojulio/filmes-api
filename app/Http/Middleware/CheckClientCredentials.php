<?php

namespace App\Http\Middleware;

use Closure;

class CheckClientCredentials
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
        if ($request->apiKey == '') {
            return redirect('/');
        } else { 
            if ($request->apiKey) { 
                return $next($request);
            } else { 
                return response("Invalid access key");
            }

        } 
    }
}
