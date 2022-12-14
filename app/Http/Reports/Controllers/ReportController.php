<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\ReportRequest;
use App\Http\Reports\ViewModels\CreateReportViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Reports/Create', new CreateReportViewModel());
    }

    public function store(ReportRequest $request): Response
    {
        return redirect()->to(route('report.index'))->with('flash.success', 'Report successfully saved!');
    }
}
