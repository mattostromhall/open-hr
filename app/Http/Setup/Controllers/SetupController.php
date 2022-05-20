<?php

namespace App\Http\Setup\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Domain\Organisation\Actions\CompleteSetupAction;
use Domain\Organisation\Models\Organisation;
use App\Http\Support\Controllers\Controller;

class SetupController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Setup/Index', [
            'stage' => $this->calculatedStage()
        ]);
    }

    public function store(CompleteSetupAction $completeSetup): RedirectResponse
    {
        $completeSetup->execute();

        return redirect()->route('dashboard');
    }

    protected function calculatedStage(): int
    {
        return Organisation::first()
            ? 2
            : 1;
    }
}
