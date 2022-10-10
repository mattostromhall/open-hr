<?php

namespace App\Http\Recruitment\ViewModels;

class ShowVacancyViewModel extends VacancyViewModel
{
    public function applications()
    {
        return $this->vacancy->applications;
    }
}
