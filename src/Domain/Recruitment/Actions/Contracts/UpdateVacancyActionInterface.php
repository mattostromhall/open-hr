<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Models\Vacancy;

interface UpdateVacancyActionInterface
{
    public function execute(Vacancy $vacancy, VacancyData $data): bool;
}
