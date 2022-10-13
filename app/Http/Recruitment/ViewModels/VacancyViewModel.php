<?php

namespace App\Http\Recruitment\ViewModels;

use App\Http\Support\ViewModels\ViewModel;
use Domain\Recruitment\Models\Vacancy;

class VacancyViewModel extends ViewModel
{
    public function __construct(protected Vacancy $vacancy)
    {
        //
    }

    public function active(): string
    {
        return 'overview';
    }

    public function vacancy(): array
    {
        return $this->vacancy->only(
            'id',
            'public_id',
            'title',
            'description',
            'location',
            'contract_type',
            'contract_length',
            'remuneration',
            'remuneration_currency',
            'open_at',
            'close_at'
        );
    }

    public function contact()
    {
        return $this->vacancy->contact->only('id', 'full_name');
    }

    public function applications()
    {
        return $this->vacancy->applications;
    }
}