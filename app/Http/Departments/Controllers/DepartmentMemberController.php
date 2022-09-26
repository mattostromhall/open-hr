<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\Requests\DepartmentMembersRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\ManageDepartmentMembersAction;
use Domain\Organisation\Models\Department;
use Illuminate\Http\RedirectResponse;

class DepartmentMemberController extends Controller
{
    public function __invoke(DepartmentMembersRequest $request, Department $department, ManageDepartmentMembersAction $manageDepartmentMembers): RedirectResponse
    {
        $manageDepartmentMembers->execute($department, $request->validated('members'));

        return back()->with('flash.success', 'Department Members updated!');
    }
}
