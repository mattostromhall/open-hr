<?php

namespace App\Http\Auth\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Auth\Requests\PasswordResetRequest;
use App\Http\Support\Controllers\Controller;

class PasswordResetLinkController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(PasswordResetRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', $status);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
