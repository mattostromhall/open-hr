<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Actions\Contracts\DeleteVacancyActionInterface;
use Domain\Recruitment\Models\Vacancy;

class DeleteVacancyAction implements DeleteVacancyActionInterface
{
    public function execute(Vacancy $vacancy): bool
    {
        return $vacancy->delete();
    }
}
