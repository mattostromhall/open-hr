<?php

namespace App\Http\Auth\Controllers;

use Domain\Auth\Actions\Contracts\CreateUserActionInterface;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Auth\Requests\StoreUserRequest;
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

    public function store(StoreUserRequest $request, CreateUserActionInterface $createUser): RedirectResponse
    {
        $user = $createUser->execute($request->userData());

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
