<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\RoleRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\SyncRolesAction;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function __invoke(RoleRequest $request, User $user, SyncRolesAction $syncRoles): RedirectResponse
    {
        $syncRoles->execute($user, $request->validated('direct_reports'));

        return back()->with('flash.success', 'Roles updated!');
    }
}
