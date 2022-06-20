<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\ReviewHolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Holiday;
use Inertia\Inertia;
use Inertia\Response;

class ReviewHolidayController extends Controller
{
    public function __invoke(Holiday $holiday): Response
    {
        return Inertia::render('Absences/Holiday/Review', new ReviewHolidayViewModel($holiday));
    }
}
