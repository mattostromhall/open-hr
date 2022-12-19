<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\ReportRequest;
use App\Http\Reports\ViewModels\ReportsViewModel;
use App\Http\Reports\ViewModels\ReportViewModel;
use App\Http\Support\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Support\Actions\DeleteReportAction;
use Support\Actions\SaveReportAction;
use Support\Actions\UpdateReportAction;
use Support\Models\Report;

class ReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): Response
    {
        $this->authorize('view', Report::class);

        return Inertia::render('Reports/Index', new ReportsViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', Report::class);

        return Inertia::render('Reports/Create', new ReportViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(ReportRequest $request, SaveReportAction $saveReport): RedirectResponse
    {
        $this->authorize('create', Report::class);

        $saveReport->execute($request->reportData());

        return redirect()->to(route('report.index'))->with('flash.success', 'Report successfully saved!');
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Report $report): Response
    {
        $this->authorize('update', $report);

        return Inertia::render('Reports/Edit', new ReportViewModel($report));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(ReportRequest $request, Report $report, UpdateReportAction $updateReport): RedirectResponse
    {
        $this->authorize('update', $report);

        $updated = $updateReport->execute($report, $request->reportData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Report, please try again.');
        }

        return redirect()->to(route('report.index'))->with('flash.success', 'Report updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Report $report, DeleteReportAction $deleteReport): RedirectResponse
    {
        $this->authorize('delete', $report);

        $deleted = $deleteReport->execute($report);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the Report, please try again.');
        }

        return redirect()->to(route('report.index'))->with('flash.success', 'Report deleted!');
    }
}
