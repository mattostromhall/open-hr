<?php

namespace App\Http\Support\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user()?->active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $request->session()->flash('flash.error', ['deactivated' => 'Access denied, your account has been deactivated.']);

            return redirect(route('login'));
        }

        return $next($request);
    }
}
