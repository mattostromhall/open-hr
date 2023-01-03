<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\ImpersonationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class ImpersonationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(ImpersonationRequest $request): RedirectResponse
    {
        $this->authorize('impersonate', User::class);

        $request->impersonate();

        return redirect()->to(route('dashboard'));
    }

    public function destroy(ImpersonationRequest $request): RedirectResponse
    {
        $request->cancel();

        return redirect()->to(route('dashboard'));
    }
}
