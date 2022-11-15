<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\LogSicknessRequest;
use App\Http\Absences\Requests\UpdateSicknessRequest;
use App\Http\Absences\ViewModels\SicknessesViewModel;
use App\Http\Absences\ViewModels\SicknessViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\AmendSicknessAction;
use Domain\Absences\Actions\CancelSicknessAction;
use Domain\Absences\Actions\LogSicknessAction;
use Domain\Absences\DataTransferObjects\LoggedSicknessData;
use Domain\Absences\DataTransferObjects\SicknessData;
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
        $logSickness->execute($request->loggedSicknessData());

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

    public function update(UpdateSicknessRequest $request, Sickness $sickness, AmendSicknessAction $amendSickness): RedirectResponse
    {
        $updated = $amendSickness->execute($sickness, $request->loggedSicknessData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Sickness, please try again.');
        }

        return redirect()->to(route('sickness.index'))->with('flash.success', 'Sickness updated!');
    }

    public function destroy(Sickness $sickness, CancelSicknessAction $cancelSickness): RedirectResponse
    {
        $cancelled = $cancelSickness->execute($sickness, SicknessData::from($sickness->toArray()));

        if (! $cancelled) {
            return back()->with('flash.error', 'There was a problem with cancelling the Sick day, please try again.');
        }

        return redirect()->to(route('sickness.index'))->with('flash.success', 'Sick day cancelled!');
    }
}
