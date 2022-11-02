<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreOneToOneRequest;
use App\Http\Performance\Requests\UpdateOneToOneRequest;
use App\Http\Performance\ViewModels\OneToOneViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\AmendOneToOneAction;
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
        $scheduleOneToOne->execute(
            OneToOneData::from($request->validatedData())
        );

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
        $oneToOneData = OneToOneData::from([
            ...$oneToOne->only('person_status', 'manager_status', 'scheduled_at', 'recurring', 'recurrence_interval', 'completed_at', 'notes'),
            ...$request->filteredValidatedData()
        ]);

        $updated = $amendOneToOne->execute($oneToOne, $oneToOneData);

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem with updating the One-to-one, please try again.');
        }

        return redirect()->to(route('performance.index'))->with('flash.success', 'One-to-one updated!');
    }
}
