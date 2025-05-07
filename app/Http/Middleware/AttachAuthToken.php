<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AttachAuthToken
{

    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->cookie('auth_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }

}
