<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreOneToOneRequest;
use App\Http\Performance\ViewModels\OneToOneViewModel;
use App\Http\Support\Controllers\Controller;
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
}
