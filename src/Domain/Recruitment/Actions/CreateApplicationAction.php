<?php

namespace Domain\Recruitment\Actions;

use Domain\Recruitment\Actions\Contracts\CreateApplicationActionInterface;
use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Models\Application;

class CreateApplicationAction implements CreateApplicationActionInterface
{
    public function execute(ApplicationData $data): Application
    {
        return Application::create([
            'vacancy_id' => $data->vacancy->id,
            'status' => $data->status,
            'name' => $data->name,
            'contact_number' => $data->contact_number,
            'contact_email' => $data->contact_email,
            'cover_letter' => $data->cover_letter
        ]);
    }
}
