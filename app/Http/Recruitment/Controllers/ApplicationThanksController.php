<?php

namespace App\Http\Recruitment\Controllers;

use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ApplicationThanksController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Recruitment/Applications/Thanks');
    }
}
