<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\AddressRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\CreateAddressAction;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{
    public function store(AddressRequest $request, CreateAddressAction $createAddress): RedirectResponse
    {
        $createAddress->execute($request->addressData());

        return back()->with('flash.success', 'Address successfully created!');
    }

    public function update(AddressRequest $request, Address $address, UpdateAddressAction $updateAddress): RedirectResponse
    {
        $updated = $updateAddress->execute($address, $request->addressData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Address, please try again.');
        }

        return back()->with('flash.success', 'Address successfully updated!');
    }
}
