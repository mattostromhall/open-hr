<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class PersonViewModel extends ViewModel
{
    public function __construct(protected Person $person)
    {
        //
    }

    public function person(): Person
    {
        return $this->person;
    }
}
