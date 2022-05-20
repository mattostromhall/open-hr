<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class PersonDashboardViewModel extends ViewModel
{
    public function person()
    {
        return auth()->user()?->person->only('full_name', 'position');
    }

    public function holidayRemaining()
    {
        return 10;
    }

    public function sickDaysRemaining()
    {
        return 3;
    }
}
