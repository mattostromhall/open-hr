<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\BulkDeleteReportsRequest;
use App\Http\Support\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Support\Actions\Contracts\BulkDeleteReportsActionInterface;
use Support\Models\Report;

class BulkDeleteReportsController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(BulkDeleteReportsRequest $request, BulkDeleteReportsActionInterface $bulkDelete): RedirectResponse
    {
        $this->authorize('delete', Report::class);

        $deleted = DB::transaction(
            fn () => $bulkDelete->execute($request->validated('reports'))
        );

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem deleting the selected Reports, please try again.');
        }

        return back()->with('flash.success', 'Selected Reports deleted!');
    }
}
