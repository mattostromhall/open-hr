<?php

namespace App\Http\Setup\Controllers;

use App\Http\People\ViewModels\SetupViewModel;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Domain\Organisation\Actions\CompleteSetupAction;
use App\Http\Support\Controllers\Controller;

class SetupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Setup/Index', new SetupViewModel());
    }

    public function store(CompleteSetupAction $completeSetup): RedirectResponse
    {
        $completeSetup->execute();

        return redirect()->route('dashboard');
    }
}
