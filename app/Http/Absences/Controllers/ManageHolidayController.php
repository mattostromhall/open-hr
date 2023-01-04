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
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ManageHolidayController extends Controller
{
    public function __invoke(): Response
    {
        if (! Gate::allows('manage-performance')) {
            abort(403);
        }

        return Inertia::render('Absences/Holiday/Manage', new HolidaysViewModel());
    }
}
