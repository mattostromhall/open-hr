<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\ManageSicknessesViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Sickness;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class ManageSicknessController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('manage', Sickness::class);

        return Inertia::render('Absences/Sickness/Manage', new ManageSicknessesViewModel());
    }
}
