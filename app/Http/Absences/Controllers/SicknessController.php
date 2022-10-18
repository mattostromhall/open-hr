<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\LogSicknessRequest;
use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\Absences\ViewModels\SicknessesViewModel;
use App\Http\Absences\ViewModels\SicknessViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\AmendHolidayAction;
use Domain\Absences\Actions\LogSicknessAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\DataTransferObjects\LogSicknessData;
use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SicknessController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Sickness/Index', new SicknessesViewModel());
    }

    public function store(LogSicknessRequest $request, LogSicknessAction $logSickness): RedirectResponse
    {
        $logSickness->execute(
            LogSicknessData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Sick days logged!');
    }

    public function show(Sickness $sickness): Response
    {
        return Inertia::render('Absences/Sickness/Show', new SicknessViewModel($sickness));
    }

    public function edit(Sickness $sickness): Response
    {
        return Inertia::render('Absences/Sickness/Edit', new SicknessViewModel($sickness));
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
