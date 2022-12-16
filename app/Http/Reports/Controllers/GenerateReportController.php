<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Jobs\GenerateReportJob;
use App\Http\Reports\Requests\ReportRequest;
use App\Http\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class GenerateReportController extends Controller
{
    public function __invoke(ReportRequest $request, GenerateReportJob $generateReport): RedirectResponse
    {
        $generateReport->dispatch($request->reportData());

        return back()->with('flash.success', 'Report generation requested!');
    }
}
