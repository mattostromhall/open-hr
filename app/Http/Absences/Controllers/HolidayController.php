<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\StoreHolidayRequest;
use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\HolidaysViewModel;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\Actions\UpdateHolidayAction;
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
        $requestHoliday->execute(
            HolidayData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Holiday request submitted!');
    }

    public function show(Holiday $holiday): Response
    {
        return Inertia::render('Absences/Holiday/Show', new HolidayViewModel($holiday));
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday, UpdateHolidayAction $updateHoliday): RedirectResponse
    {
        $holidayData = HolidayData::from([
            $holiday->person,
            ...$holiday->only('status', 'start_at', 'finish_at', 'half_day', 'notes'),
            ...$request->validatedData()
        ]);

        $updated = $updateHoliday->execute($holiday, $holidayData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when reviewing the Holiday request, please try again.');
        }

        return redirect()->to(route('dashboard'))->with('flash.success', "Holiday {$holidayData->status->status()}.");
    }
}
