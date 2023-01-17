<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Recruitment\Requests\BulkDeleteApplicationsRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Recruitment\Actions\BulkDeleteApplicationsAction;
use Domain\Recruitment\Models\Application;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class BulkDeleteApplicationsController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(BulkDeleteApplicationsRequest $request, BulkDeleteApplicationsAction $bulkDelete): RedirectResponse
    {
        $this->authorize('bulkDelete', Application::class);

        $deleted = DB::transaction(
            fn () => $bulkDelete->execute($request->validated('applications'))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the selected Applications, please try again.');
        }

        return back()->with('flash.success', 'Selected Applications deleted!');
    }
}
