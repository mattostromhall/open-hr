<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\ViewModels\CreateDepartmentViewModel;
use App\Http\Departments\ViewModels\DepartmentsViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Departments/Index', new DepartmentsViewModel());
    }

    public function create(): Response
    {
        return Inertia::render('Departments/Create', new CreateDepartmentViewModel());
    }
}
