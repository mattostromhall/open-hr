<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Collection;

class SetupViewModel extends ViewModel
{
    public function stage(): int
    {
        return Organisation::first()
            ? 2
            : 1;
    }
}
