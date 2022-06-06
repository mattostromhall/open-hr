<?php

namespace App\Http\Auth\Controllers;

use App\Http\Auth\Requests\NewPasswordRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\DataTransferObjects\ResetPasswordData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function store(NewPasswordRequest $request, ResetPasswordAction $resetPassword): RedirectResponse
    {
        $status = $resetPassword->execute(
            ResetPasswordData::from($request->data())
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', $status);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
