<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\ViewModels\ManagePerformanceViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ManagePerformanceController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Performance/Manage', new ManagePerformanceViewModel());
    }
}
