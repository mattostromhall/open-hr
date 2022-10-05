<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;

class VacanciesViewModel extends ViewModel
{
    public function active(): string
    {
        return 'post';
    }
}
