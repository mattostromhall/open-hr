<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class PeopleViewModel extends ViewModel
{
    public function people(): Collection
    {
        return Person::all();
    }
}
