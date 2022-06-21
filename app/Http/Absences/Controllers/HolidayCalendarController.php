<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\HolidayCalendarViewModel;
use App\Http\Support\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HolidayCalendarController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Absences/Holiday/Calendar', new HolidayCalendarViewModel());
    }
}
