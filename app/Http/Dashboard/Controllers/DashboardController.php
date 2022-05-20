<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\PersonDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard', new PersonDashboardViewModel());
    }
}
