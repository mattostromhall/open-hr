<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\RoleRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\Contracts\SyncRolesActionInterface;
use Domain\Auth\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Silber\Bouncer\Database\Role;

class RoleController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(RoleRequest $request, User $user, SyncRolesActionInterface $syncRoles): RedirectResponse
    {
        $this->authorize('sync', Role::class);

        DB::transaction(
            fn () => $syncRoles->execute($user, $request->validated('roles'))
        );

        return back()->with('flash.success', 'Roles updated!');
    }
}
