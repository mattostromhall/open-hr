<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\DataTransferObjects\VacancyData;
use Domain\Recruitment\Models\Vacancy;

class UpdateVacancyAction
{
    public function execute(Vacancy $vacancy, VacancyData $data): bool
    {
        return $vacancy->update([
            'contact_id' => $data->contact->id,
            'title' => $data->title,
            'description' => $data->description,
            'location' => $data->location,
            'contract_type' => $data->contract_type,
            'contract_length' => $data->contract_length,
            'remuneration' => $data->remuneration,
            'remuneration_currency' => $data->remuneration_currency,
            'open_at' => $data->open_at,
            'close_at' => $data->close_at
        ]);
    }
}
