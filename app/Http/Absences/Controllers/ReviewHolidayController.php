<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\ReviewHolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\ReviewHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewHolidayController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function show(Holiday $holiday): Response
    {
        $this->authorize('review', $holiday);

        return Inertia::render('Absences/Holiday/Review', new ReviewHolidayViewModel($holiday));
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday, ReviewHolidayAction $reviewHoliday): RedirectResponse
    {
        $holidayData = $request->holidayData();

        $reviewed = $reviewHoliday->execute($holiday, $holidayData);

        if (! $reviewed) {
            return back()->with('flash.error', 'There was a problem when reviewing the Holiday request, please try again.');
        }

        return redirect()->to(route('dashboard'))->with('flash.success', "Holiday {$holidayData->status->statusDisplay()}.");
    }
}
