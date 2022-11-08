<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\Requests\DepartmentRequest;
use App\Http\Departments\ViewModels\CreateDepartmentViewModel;
use App\Http\Departments\ViewModels\DepartmentsViewModel;
use App\Http\Departments\ViewModels\DepartmentViewModel;
use App\Http\Departments\ViewModels\EditDepartmentViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\AmendDepartmentAction;
use Domain\Organisation\Actions\SetupDepartmentAction;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;
use Illuminate\Http\RedirectResponse;
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

    public function store(DepartmentRequest $request, SetupDepartmentAction $setupDepartment): RedirectResponse
    {
        $department = $setupDepartment->execute($request->departmentData());

        return redirect(
            route('department.show', [
                'department' => $department
            ])
        )->with('flash.success', 'Department created!');
    }

    public function show(Department $department): Response
    {
        return Inertia::render('Departments/Show', new DepartmentViewModel($department));
    }

    public function edit(Department $department): Response
    {
        return Inertia::render('Departments/Edit', new EditDepartmentViewModel($department));
    }

    public function update(DepartmentRequest $request, Department $department, AmendDepartmentAction $amendDepartment): RedirectResponse
    {
        $updated = $amendDepartment->execute($department, $request->departmentData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Department, please try again.');
        }

        return redirect()->to(route('department.index'))->with('flash.success', 'Department updated!');
    }
}
