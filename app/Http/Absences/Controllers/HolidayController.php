<?php

namespace App\Http\Absences\Controllers;

use App\Http\Absences\Requests\HolidayRequest;
use App\Http\Absences\ViewModels\HolidayViewModel;
use App\Http\People\Requests\AddressRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\People\Actions\CreateAddressAction;
use Domain\People\Actions\CreateHolidayAction;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class HolidayController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Absences/Holiday/Index', new HolidayViewModel());
    }

    public function store(HolidayRequest $request, CreateHolidayAction $createHoliday): RedirectResponse
    {
        $createHoliday->execute(
            HolidayData::from($request->validatedData())
        );

        return back()->with('flash.success', 'Holiday request submitted!');
    }
//
//    public function update(AddressRequest $request, Address $address, UpdateAddressAction $updateAddress): RedirectResponse
//    {
//        $updated = $updateAddress->execute($address, AddressData::from($request->validatedData()));
//
//        if (! $updated) {
//            return back()->with('flash.error', 'There was a problem when updating your Address, please try again.');
//        }
//
//        return back()->with('flash.success', 'Address successfully updated!');
//    }
}
