<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Models\Vacancy;

class DeleteVacancyAction
{
    public function execute(Vacancy $vacancy): bool
    {
        return $vacancy->delete();
    }
}
