<?php

namespace App\Http\Departments\Controllers;

use App\Http\Departments\Requests\BulkDeleteDepartmentsRequest;
use App\Http\People\Requests\BulkDeletePeopleRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Organisation\Actions\Contracts\BulkDeleteDepartmentsActionInterface;
use Domain\Organisation\Models\Department;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BulkDeleteDepartmentsController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(BulkDeleteDepartmentsRequest $request, BulkDeleteDepartmentsActionInterface $bulkDelete): RedirectResponse
    {
        $this->authorize('bulkDelete', Department::class);

        $deleted = DB::transaction(
            fn () => $bulkDelete->execute($request->validated('departments'))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the selected Departments, please try again.');
        }

        return back()->with('flash.success', 'Selected Departments deleted!');
    }
}
