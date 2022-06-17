<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\HolidayRequest;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\People\Requests\AddressRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\People\Actions\CreateAddressAction;
use Domain\Absences\Actions\CreateHolidayAction;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ReviewHolidayController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Absences/Holiday/Review', new HolidayViewModel());
    }
}
