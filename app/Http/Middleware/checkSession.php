<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkSession
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
        
        if (Auth::user() === null){
            exit(
                json_encode(
                    array(
                    'error' => 1,
                    'message' => 'You are logged out, Login again.',
                    'loggedIn' => 0
                    )
                )
            );
        }else{
            return $next($request);
        }
    }
}
