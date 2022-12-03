<?php

namespace App\Http\People\Controllers;

use App\Http\People\Requests\AddressRequest;
use App\Http\Support\Controllers\Controller;
use Domain\People\Actions\CreateAddressAction;
use Domain\People\Actions\DeleteAddressAction;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\Models\Address;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class AddressController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function store(AddressRequest $request, CreateAddressAction $createAddress): RedirectResponse
    {
        $this->authorize('create', Address::class);

        $createAddress->execute($request->addressData());

        return back()->with('flash.success', 'Address successfully created!');
    }

    /**
     * @throws AuthorizationException
     */
    public function update(AddressRequest $request, Address $address, UpdateAddressAction $updateAddress): RedirectResponse
    {
        $this->authorize('update', $address);

        $updated = $updateAddress->execute($address, $request->addressData());

        if (! $updated) {
            return back()->with('flash.error', 'There was a problem when updating your Address, please try again.');
        }

        return back()->with('flash.success', 'Address successfully updated!');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Address $address, DeleteAddressAction $deleteAddress): RedirectResponse
    {
        $this->authorize('delete', $address);

        $deleted = $deleteAddress->execute($address);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem when deleting Address, please try again.');
        }

        return back()->with('flash.success', 'Address deleted!');
    }
}
