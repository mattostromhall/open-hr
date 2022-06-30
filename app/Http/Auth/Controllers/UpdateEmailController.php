<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\UpdateEmailRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\UpdateEmailAction;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;

class UpdateEmailController extends Controller
{
    public function __invoke(UpdateEmailRequest $request, User $user, UpdateEmailAction $updateEmail): RedirectResponse
    {
        $updated = $updateEmail->execute($user, $request->validated('email'));

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating the Email Address, please try again.');
        }

        return back()->with('flash.success', 'Email Address successfully updated!');
    }
}
