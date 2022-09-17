<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\ManagementDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ManagementDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard/Management', new ManagementDashboardViewModel());
    }
}
