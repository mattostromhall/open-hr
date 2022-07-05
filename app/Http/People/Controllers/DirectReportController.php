<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\DirectReportRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\ManageDirectReportsAction;
use Domain\People\Models\Person;
use Illuminate\Http\RedirectResponse;

class DirectReportController extends Controller
{
    public function __invoke(DirectReportRequest $request, Person $person, ManageDirectReportsAction $syncDirectReports): RedirectResponse
    {
        $syncDirectReports->execute($person, $request->validated('direct_reports'));

        return back()->with('flash.success', 'Direct reports updated!');
    }
}
