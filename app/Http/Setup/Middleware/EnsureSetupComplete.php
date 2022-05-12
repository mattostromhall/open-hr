<?php

namespace App\Http\Setup\Middleware;

use Closure;
use Illuminate\Http\Request;
use Domain\Organisation\Models\Organisation;

class EnsureSetupComplete
{
    public function handle(Request $request, Closure $next)
    {
        if (! $this->isSetup()) {
            return redirect(route('setup'));
        }

        return $next($request);
    }

    protected function isSetup(): bool
    {
        return (bool) Organisation::first()?->setup_at;
    }
}
