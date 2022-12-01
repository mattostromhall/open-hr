<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\OrganisationDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Models\Organisation;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationDashboardController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('dashboard', Organisation::class);

        return Inertia::render('Dashboard/Organisation', new OrganisationDashboardViewModel(organisation()));
    }
}
