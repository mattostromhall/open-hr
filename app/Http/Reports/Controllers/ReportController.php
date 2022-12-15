<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\ReportRequest;
use App\Http\Reports\ViewModels\CreateReportViewModel;
use App\Http\Reports\ViewModels\ReportsViewModel;
use App\Http\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Support\Actions\SaveReportAction;

class ReportController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Reports/Index', new ReportsViewModel());
    }

    public function create(): Response
    {
        return Inertia::render('Reports/Create', new CreateReportViewModel());
    }

    public function store(ReportRequest $request, SaveReportAction $saveReport): RedirectResponse
    {
        $saveReport->execute($request->reportData());

        return redirect()->to(route('report.index'))->with('flash.success', 'Report successfully saved!');
    }
}
