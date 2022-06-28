<?php

namespace App\Http\People\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\SyncDirectReportsAction;
use Domain\People\Models\Person;
use Illuminate\Http\Request;

class DirectReportController extends Controller
{
    public function __invoke(Request $request, Person $person, SyncDirectReportsAction $syncDirectReports): \Illuminate\Http\RedirectResponse
    {
        $syncDirectReports->execute($person, $request->direct_reports);

        return back()->with('flash.success', 'Direct reports updated!');
    }
}
