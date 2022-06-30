<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class CreatePersonViewModel extends ViewModel
{
    public function people(): Collection
    {
        return Person::query()
            ->select('id', 'first_name', 'last_name')
            ->get();
    }

    public function departments(): Collection
    {
        return Department::all();
    }
}
