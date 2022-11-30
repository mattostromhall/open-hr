<?php

namespace App\Http\Dashboard\Controllers;

use App\Http\Dashboard\ViewModels\DepartmentDashboardViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentDashboardController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('dashboard', Department::class);

        return Inertia::render('Dashboard/Department', new DepartmentDashboardViewModel());
    }
}
