<?php

namespace App\Http\People\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Organisation\Models\Organisation;

class SetupViewModel extends ViewModel
{
    public function stage(): int
    {
        return Organisation::first()
            ? 2
            : 1;
    }
}
