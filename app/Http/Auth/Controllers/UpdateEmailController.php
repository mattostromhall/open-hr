<?php

namespace App\Http\Auth\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\UpdateEmailAction;
use Illuminate\Http\Request;

class UpdateEmailController extends Controller
{
    public function __invoke(Request $request, UpdateEmailAction $updateEmail)
    {
        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        $updateEmail->execute(auth()->user(), $validated['email']);
    }
}
