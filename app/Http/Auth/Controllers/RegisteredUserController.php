<?php

namespace App\Http\Auth\Controllers;

use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\DataTransferObjects\UserData;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Auth\Requests\RegisterUserRequest;
use App\Http\Support\Controllers\Controller;

class RegisteredUserController extends Controller
{
    public function create(): Response|RedirectResponse
    {
        if (User::first()) {
            return redirect()->route('login');
        }

        return Inertia::render('Auth/Register');
    }

    public function store(RegisterUserRequest $request, CreateUserAction $createUser): RedirectResponse
    {
        $user = $createUser->execute(
            UserData::from($request->validated())
        );

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
