<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\OrganisationDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard/Organisation', new OrganisationDashboardViewModel());
    }
}
