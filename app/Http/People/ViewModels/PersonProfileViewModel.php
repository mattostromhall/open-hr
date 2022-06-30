<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class PersonProfileViewModel extends ViewModel
{
    public function user()
    {
        return auth()->user()
            ->only('id', 'email');
    }

    public function person()
    {
        return person()->only(
            'id',
            'full_name',
            'title',
            'first_name',
            'last_name',
            'initials',
            'pronouns',
            'dob',
            'contact_number',
            'contact_email'
        );
    }

    public function address()
    {
        return person()->address;
    }
}
