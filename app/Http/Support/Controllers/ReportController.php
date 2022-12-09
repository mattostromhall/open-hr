<?php

namespace App\Http\Support\Controllers;

use App\Http\Support\Requests\ReportRequest;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function show(ReportRequest $request): Response
    {
        return Inertia::render('Reports/Create');
    }
}
