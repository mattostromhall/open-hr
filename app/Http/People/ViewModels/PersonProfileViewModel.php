<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class PersonProfileViewModel extends ViewModel
{
    public function email()
    {
        return auth()->user()->email;
    }

    public function person()
    {
        return person()->only('full_name', 'initials', 'position');
    }

    public function addresses()
    {
        return person()->addresses;
    }
}
