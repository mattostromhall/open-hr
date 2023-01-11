<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\LogSicknessRequest;
use App\Http\Absences\Requests\UpdateSicknessRequest;
use App\Http\Absences\ViewModels\SicknessesViewModel;
use App\Http\Absences\ViewModels\SicknessViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\Contracts\AmendSicknessActionInterface;
use Domain\Absences\Actions\Contracts\CancelSicknessActionInterface;
use Domain\Absences\Actions\Contracts\LogSicknessActionInterface;
use Domain\Absences\DataTransferObjects\SicknessData;
use Domain\Absences\Models\Sickness;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SicknessController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Sickness/Index', new SicknessesViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function store(LogSicknessRequest $request, LogSicknessActionInterface $logSickness): RedirectResponse
    {
        $this->authorize('create', Sickness::class);

        DB::transaction(
            fn () => $logSickness->execute($request->loggedSicknessData())
        );

        return back()->with('flash.success', 'Sick days logged!');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Sickness $sickness): Response
    {
        $this->authorize('create', $sickness);

        return Inertia::render('Absences/Sickness/Show', new SicknessViewModel($sickness));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Sickness $sickness): Response
    {
        $this->authorize('update', $sickness);

        return Inertia::render('Absences/Sickness/Edit', new SicknessViewModel($sickness));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateSicknessRequest $request, Sickness $sickness, AmendSicknessActionInterface $amendSickness): RedirectResponse
    {
        $this->authorize('update', $sickness);

        $updated = DB::transaction(
            fn () => $amendSickness->execute($sickness, $request->loggedSicknessData())
        );

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the Sickness, please try again.');
        }

        return redirect()->to(route('sickness.index'))->with('flash.success', 'Sickness updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Sickness $sickness, CancelSicknessActionInterface $cancelSickness): RedirectResponse
    {
        $this->authorize('delete', $sickness);

        $cancelled = DB::transaction(
            fn () => $cancelSickness->execute($sickness, SicknessData::from($sickness->toArray()))
        );

        if (! $cancelled) {
            return back()->with('flash.error', 'There was a problem with cancelling the Sick day, please try again.');
        }

        return redirect()->to(route('sickness.index'))->with('flash.success', 'Sick day cancelled!');
    }
}
