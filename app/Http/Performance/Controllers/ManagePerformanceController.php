<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\ViewModels\ManagePerformanceViewModel;
use App\Http\Support\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ManagePerformanceController extends Controller
{
    public function __invoke(): Response
    {
        if (! Gate::allows('manage-performance')) {
            abort(403);
        }

        return Inertia::render('Performance/Manage', new ManagePerformanceViewModel());
    }
}
