<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\ViewModels\ManageHolidaysViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Models\Holiday;
use Illuminate\Auth\Access\AuthorizationException;
use Inertia\Inertia;
use Inertia\Response;

class ManageHolidayController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(): Response
    {
        $this->authorize('manage', Holiday::class);

        return Inertia::render('Absences/Holiday/Manage', new ManageHolidaysViewModel());
    }
}
