<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\HolidayCalendarViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Holiday;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class HolidayCalendarController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('viewCalendar', Holiday::class);

        return Inertia::render('Absences/Holiday/Calendar', new HolidayCalendarViewModel());
    }
}
