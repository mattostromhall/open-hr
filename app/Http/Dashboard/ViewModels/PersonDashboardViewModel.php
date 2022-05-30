<?php

namespace App\Http\Dashboard\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class PersonDashboardViewModel extends ViewModel
{
    public function person()
    {
        return person()->only('full_name', 'initials', 'position');
    }

    public function holidayRemaining()
    {
        return person()->holiday_allocation - person()->holidayTaken();
    }

    public function sickDaysRemaining()
    {
        return person()->sickness_allocation - person()->sicknesses()->count();
    }
}
