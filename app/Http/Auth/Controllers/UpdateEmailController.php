<?php

namespace App\Http\Auth\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\UpdateEmailAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UpdateEmailController extends Controller
{
    public function __invoke(Request $request, UpdateEmailAction $updateEmail): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        $updated = $updateEmail->execute(auth()->user(), $validated['email']);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Email Address, please try again.');
        }

        return back()->with('flash.success', 'Email Address successfully updated!');
    }
}
