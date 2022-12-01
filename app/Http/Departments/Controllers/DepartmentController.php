<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\Requests\DepartmentRequest;
use App\Http\Departments\ViewModels\CreateDepartmentViewModel;
use App\Http\Departments\ViewModels\DepartmentsViewModel;
use App\Http\Departments\ViewModels\DepartmentViewModel;
use App\Http\Departments\ViewModels\EditDepartmentViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\AmendDepartmentAction;
use Domain\Organisation\Actions\DissolveDepartmentAction;
use Domain\Organisation\Actions\SetupDepartmentAction;
use Domain\Organisation\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class DepartmentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('viewAll', Department::class);

        return Inertia::render('Departments/Index', new DepartmentsViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Department::class);

        return Inertia::render('Departments/Create', new CreateDepartmentViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(DepartmentRequest $request, SetupDepartmentAction $setupDepartment): RedirectResponse
    {
        $this->authorize('create', Department::class);

        $department = $setupDepartment->execute($request->departmentData());

        return redirect(
            route('department.show', [
                'department' => $department
            ])
        )->with('flash.success', 'Department created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Department $department): Response
    {
        $this->authorize('view', $department);

        return Inertia::render('Departments/Show', new DepartmentViewModel($department));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Department $department): Response
    {
        $this->authorize('update', $department);

        return Inertia::render('Departments/Edit', new EditDepartmentViewModel($department));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(DepartmentRequest $request, Department $department, AmendDepartmentAction $amendDepartment): RedirectResponse
    {
        $this->authorize('update', $department);

        $updated = $amendDepartment->execute($department, $request->departmentData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Department, please try again.');
        }

        return redirect()->to(route('department.index'))->with('flash.success', 'Department updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Department $department, DissolveDepartmentAction $dissolveDepartment): RedirectResponse
    {
        $this->authorize('delete', Department::class);

        $dissolved = $dissolveDepartment->execute($department);

        if (! $dissolved) {
            return back()->with('flash.error', 'There was a problem with dissolving the Department, please try again.');
        }

        return redirect()->to(route('department.index'))->with('flash.success', 'Department dissolved!');
    }
}
