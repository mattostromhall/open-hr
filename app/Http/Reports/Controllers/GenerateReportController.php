<?php

namespace App\Http\Reports\Controllers;

use App\Http\Reports\Requests\ReportRequest;
use App\Http\Support\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use League\Csv\CannotInsertRecord;
use Support\Actions\GenerateReportAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GenerateReportController extends Controller
{
    public function store(ReportRequest $request, GenerateReportAction $generateReport): Response | RedirectResponse
    {
        try {
            $csvPath = $generateReport->execute($request->reportData());

            return back()->with([
                'flash.success' => 'Report successfully generated!',
                'csv.path' => $csvPath
            ]);
        } catch (CannotInsertRecord $e) {
            return back()->with('flash.error', 'There was a problem with generating the Report, please try again.');
        }
    }

    public function show(string $path): StreamedResponse
    {
        return Storage::download($path);
    }
}
