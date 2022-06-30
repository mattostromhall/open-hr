<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\UpdateActiveRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\UpdateActiveAction;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;

class UpdateActiveController extends Controller
{
    public function __invoke(UpdateActiveRequest $request, User $user, UpdateActiveAction $updateActive): RedirectResponse
    {
        $updated = $updateActive->execute($user, $request->validated('active'));

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating the Active state, please try again.');
        }

        $state = $request->validated('active') ? 'Activated' : 'Deactivated';

        return back()->with('flash.success', "{$state}!");
    }
}
