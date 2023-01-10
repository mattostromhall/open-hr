<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\DirectReportRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\ManageDirectReportsAction;
use Domain\People\Models\Person;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DirectReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(DirectReportRequest $request, Person $person, ManageDirectReportsAction $manageDirectReports): RedirectResponse
    {
        $this->authorize('manageDirectReports', $person);

        DB::transaction(
            fn () => $manageDirectReports->execute($person, $request->validated('direct_reports'))
        );

        return back()->with('flash.success', 'Direct reports updated!');
    }
}
