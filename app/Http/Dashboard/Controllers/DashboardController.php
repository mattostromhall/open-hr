<?php

namespace App\Http\Dashboard\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Support\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Dashboard');
    }
}
