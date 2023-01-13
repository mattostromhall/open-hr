<?php

namespace Domain\Recruitment\Actions\Contracts;

use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Models\Vacancy;

interface CreateVacancyActionInterface
{
    public function execute(VacancyData $data): Vacancy;
}
