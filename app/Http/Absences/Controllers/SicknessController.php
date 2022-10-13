<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\StoreHolidayRequest;
use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\HolidaysViewModel;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\Absences\ViewModels\SicknessesViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\AmendHolidayAction;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SicknessController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Sickness/Index', new SicknessesViewModel());
    }

    public function store(StoreHolidayRequest $request, RequestHolidayAction $requestHoliday): RedirectResponse
    {
        $requestHoliday->execute(
            HolidayData::from($request->validatedData())
        );

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
        $holidayData = HolidayData::from($request->validatedData());

        $updated = $amendHoliday->execute($holiday, $holidayData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Holiday request, please try again.');
        }

        return redirect()->to(route('holiday.index'))->with('flash.success', 'Holiday updated!');
    }
}
