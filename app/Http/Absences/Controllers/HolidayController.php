<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\StoreHolidayRequest;
use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\HolidaysViewModel;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\AmendHolidayAction;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HolidayController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Holiday/Index', new HolidaysViewModel());
    }

    public function store(StoreHolidayRequest $request, RequestHolidayAction $requestHoliday): RedirectResponse
    {
        $requestHoliday->execute($request->holidayData());

        return back()->with('flash.success', 'Holiday request submitted!');
    }

    public function show(Holiday $holiday): Response
    {
        return Inertia::render('Absences/Holiday/Show', new HolidayViewModel($holiday));
    }

    public function edit(Holiday $holiday): Response
    {
        return Inertia::render('Absences/Holiday/Edit', new HolidayViewModel($holiday));
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday, AmendHolidayAction $amendHoliday): RedirectResponse
    {
        $updated = $amendHoliday->execute($holiday, $request->holidayData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Holiday request, please try again.');
        }

        return redirect()->to(route('holiday.index'))->with('flash.success', 'Holiday updated!');
    }
}
