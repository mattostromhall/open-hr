<?php

namespace App\Http\Performance\Controllers;

use App\Http\Performance\Requests\StoreOneToOneRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Performance\Actions\ScheduleOneToOneAction;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Illuminate\Http\RedirectResponse;

class OneToOneController extends Controller
{
    public function store(StoreOneToOneRequest $request, ScheduleOneToOneAction $scheduleOneToOne): RedirectResponse
    {
        $scheduleOneToOne->execute(
            OneToOneData::from($request->validatedData())
        );

        return back()->with('flash.success', 'One-to-one requested!');
    }
}
