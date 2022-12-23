<?php

namespace App\Http\Support\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'flash' => [
                'success' => fn () => $request->session()->get('flash.success'),
                'error' => fn () => $request->session()->get('flash.error')
            ],
            'auth' => [
                'user' => $request->user()?->only('id', 'email'),
                'person' => person()?->only('id', 'full_name', 'initials'),
            ],
            'permissions' => [
                'roles' => $request->user()?->assignedRoles(),
                'abilities' => $request->user()?->assignedAbilities()
            ],
            'notifications' => person()?->notifications,
            'impersonating' => $request->session()->has('impersonator')
        ]);
    }
}
