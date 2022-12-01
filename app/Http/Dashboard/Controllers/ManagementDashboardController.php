<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\ManagementDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class ManagementDashboardController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('managementDashboard', Person::class);

        return Inertia::render('Dashboard/Management', new ManagementDashboardViewModel());
    }
}
