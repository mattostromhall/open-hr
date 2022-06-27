<?php

namespace App\Http\Support\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
