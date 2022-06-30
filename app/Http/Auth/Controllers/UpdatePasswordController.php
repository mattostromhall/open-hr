<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\UpdatePasswordRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\UpdatePasswordAction;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request, User $user, UpdatePasswordAction $updatePassword): RedirectResponse
    {
        $updated = $updatePassword->execute($user, $request->validated('password'));

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Password, please try again.');
        }

        return back()->with('flash.success', 'Password successfully updated!');
    }
}
