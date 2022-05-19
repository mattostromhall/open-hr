<?php

namespace App\Http\Setup\Middleware;

use Closure;
use Domain\Organisation\Models\Organisation;
use Illuminate\Http\Request;

class EnsureSetupComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (! $this->isSetup() && ! $this->setupRoute()) {
            return redirect(route('setup.index'));
        }

        if ($this->isSetup() && $this->setupRoute()) {
            return redirect(route('dashboard'));
        }

        return $next($request);
    }

    protected function isSetup(): bool
    {
        return (bool) Organisation::first()?->setup_at;
    }

    protected function setupRoute(): bool
    {
        return request()->route()->named('setup.index');
    }
}
