<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\DepartmentDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentDashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard/Department', new DepartmentDashboardViewModel());
    }
}
