<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\ReportRequest;
use App\Http\Support\Controllers\Controller;
use Inertia\Response;
use Support\Actions\GenerateReportAction;

class GenerateReportController extends Controller
{
    public function __invoke(ReportRequest $request, GenerateReportAction $generateReport): Response
    {
        $generateReport->execute();

        return back();
    }
}
