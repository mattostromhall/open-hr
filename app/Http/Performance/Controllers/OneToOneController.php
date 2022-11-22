<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreOneToOneRequest;
use App\Http\Performance\Requests\UpdateOneToOneRequest;
use App\Http\Performance\ViewModels\OneToOneViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendOneToOneAction;
use Domain\Performance\Actions\CancelOneToOneAction;
use Domain\Performance\Actions\ScheduleOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OneToOneController extends Controller
{
    public function store(StoreOneToOneRequest $request, ScheduleOneToOneAction $scheduleOneToOne): RedirectResponse
    {
        $scheduleOneToOne->execute($request->oneToOneData());

        return back()->with('flash.success', 'One-to-one requested!');
    }

    public function show(OneToOne $oneToOne): Response
    {
        return Inertia::render('Performance/OneToOnes/Show', new OneToOneViewModel($oneToOne));
    }

    public function edit(OneToOne $oneToOne): Response
    {
        return Inertia::render('Performance/OneToOnes/Edit', new OneToOneViewModel($oneToOne));
    }

    public function update(UpdateOneToOneRequest $request, OneToOne $oneToOne, AmendOneToOneAction $amendOneToOne): RedirectResponse
    {
        $updated = $amendOneToOne->execute($oneToOne, $request->oneToOneData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the One-to-one, please try again.');
        }

        return redirect()->to(route('performance.index'))->with('flash.success', 'One-to-one updated!');
    }

    public function destroy(OneToOne $oneToOne, CancelOneToOneAction $cancelOneToOne): RedirectResponse
    {
        $deleted = $cancelOneToOne->execute($oneToOne, OneToOneData::from($oneToOne->toArray()));

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with cancelling the One-to-one, please try again.');
        }

        return redirect()->to(route('performance.index'))->with('flash.success', 'One-to-one cancelled!');
    }
}
