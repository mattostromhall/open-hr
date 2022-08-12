<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\ViewModels\PerformanceViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PerformanceController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Performance/Index', new PerformanceViewModel());
    }
}
