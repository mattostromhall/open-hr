<?php

namespace App\Http\Auth\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Illuminate\Support\Facades\Route;

class AuthenticatedSessionViewModel extends ViewModel
{
    public function canResetPassword(): bool
    {
        return Route::has('password.request');
    }

    public function status()
    {
        return session('status');
    }

    public function deactivated()
    {
        return session('flash.error.deactivated');
    }
}
