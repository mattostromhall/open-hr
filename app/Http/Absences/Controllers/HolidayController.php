<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\StoreHolidayRequest;
use App\Http\Absences\Requests\UpdateHolidayRequest;
use App\Http\Absences\ViewModels\HolidaysViewModel;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\AmendHolidayAction;
use Domain\Absences\Actions\CancelHolidayAction;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Models\Holiday;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class HolidayController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Holiday/Index', new HolidaysViewModel());
    }

    /**
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function store(StoreHolidayRequest $request, RequestHolidayAction $requestHoliday): RedirectResponse
    {
        $this->authorize('create', Holiday::class);

        DB::transaction(
            fn () => $requestHoliday->execute($request->holidayData())
        );

        return back()->with('flash.success', 'Holiday request submitted!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Holiday $holiday): Response
    {
        $this->authorize('view', $holiday);

        return Inertia::render('Absences/Holiday/Show', new HolidayViewModel($holiday));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Holiday $holiday): Response
    {
        $this->authorize('update', $holiday);

        return Inertia::render('Absences/Holiday/Edit', new HolidayViewModel($holiday));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateHolidayRequest $request, Holiday $holiday, AmendHolidayAction $amendHoliday): RedirectResponse
    {
        $this->authorize('update', $holiday);

        $updated = $amendHoliday->execute($holiday, $request->holidayData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Holiday request, please try again.');
        }

        return redirect()->to(route('holiday.index'))->with('flash.success', 'Holiday updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Holiday $holiday, CancelHolidayAction $cancelHoliday): RedirectResponse
    {
        $this->authorize('delete', $holiday);

        $cancelled = $cancelHoliday->execute($holiday, HolidayData::from($holiday->toArray()));

        if (! $cancelled) {
            return back()->with('flash.error', 'There was a problem with cancelling the Holiday request, please try again.');
        }

        return redirect()->to(route('holiday.index'))->with('flash.success', 'Holiday request cancelled!');
    }
}
