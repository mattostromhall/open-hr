<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\Models\Vacancy;

interface DeleteVacancyActionInterface
{
    public function execute(Vacancy $vacancy): bool;
}
