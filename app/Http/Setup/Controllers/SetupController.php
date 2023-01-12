<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\ViewModels\SetupViewModel;
use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Support\Controllers\Controller;

class SetupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Setup/Index', new SetupViewModel());
    }

    public function store(CompleteSetupActionInterface $completeSetup): RedirectResponse
    {
        $completeSetup->execute();

        return redirect()->route('dashboard');
    }
}
