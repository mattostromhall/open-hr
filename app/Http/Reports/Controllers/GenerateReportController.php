<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Jobs\DeleteReportCsvAfterDownload;
use App\Http\Reports\Requests\ReportRequest;
use App\Http\Support\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use Support\Actions\GenerateReportAction;
use Support\Models\Report;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateReportController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(ReportRequest $request, GenerateReportAction $generateReport): Response | RedirectResponse
    {
        $this->authorize('create', Report::class);

        try {
            $csvPath = $generateReport->execute($request->reportData());

            return back()->with([
                'flash.success' => 'Report successfully generated! Click the button below to download.',
                'csv.path' => $csvPath
            ]);
        } catch (CannotInsertRecord $e) {
            return back()->with('flash.error', 'There was a problem with generating the Report, please try again.');
        }
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $path): StreamedResponse
    {
        $this->authorize('view', Report::class);

        DeleteReportCsvAfterDownload::dispatchAfterResponse($path);

        return Storage::download($path);
    }
}
