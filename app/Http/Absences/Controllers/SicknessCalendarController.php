<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\SicknessCalendarViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Sickness;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class SicknessCalendarController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('viewCalendar', Sickness::class);

        return Inertia::render('Absences/Sickness/Calendar', new SicknessCalendarViewModel());
    }
}
