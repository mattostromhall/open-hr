<?php

namespace App\Http\Support\Controllers;

use App\Http\Support\ViewModels\ActionLogsViewModel;
use App\Http\Support\ViewModels\ActionLogViewModel;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;
use Support\Models\ActionLog;

class CapturedExceptionController extends Controller
{
    public function __invoke(string $hash): Response
    {
        return Inertia::render('Errors/CapturedException');
    }
}
