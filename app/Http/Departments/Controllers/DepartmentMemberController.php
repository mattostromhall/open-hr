<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\Requests\DepartmentMembersRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\ManageDepartmentMembersAction;
use Domain\Organisation\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class DepartmentMemberController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(DepartmentMembersRequest $request, Department $department, ManageDepartmentMembersAction $manageDepartmentMembers): RedirectResponse
    {
        $this->authorize('manageMembers', $department);

        $manageDepartmentMembers->execute($department, $request->validated('members'));

        return back()->with('flash.success', 'Department Members updated!');
    }
}
