<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\ReviewHolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Enums\Ability;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReviewHolidayController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Holiday $holiday): Response
    {
        $this->authorize(Ability::REVIEW_HOLIDAY->value);

        return Inertia::render('Absences/Holiday/Review', new ReviewHolidayViewModel($holiday));
    }
}
