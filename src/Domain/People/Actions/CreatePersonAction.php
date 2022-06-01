<?php

namespace Domain\People\Actions;

use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Models\Person;

class CreatePersonAction
{
    public function execute(PersonData $data): Person
    {
        return Person::create([
            'user_id' => $data->user->id,
            'manager_id' => $data->manager?->id,
            'department_id' => $data->department?->id,
            'title' => $data->title,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'initials' => $data->initials,
            'pronouns' => $data->pronouns,
            'dob' => $data->dob,
            'position' => $data->position,
            'remuneration' => $data->remuneration,
            'remuneration_interval' => $data->remuneration_interval,
            'remuneration_currency' => $data->remuneration_currency,
            'base_holiday_allocation' => $data->base_holiday_allocation,
            'holiday_carry_allocation' => $data->holiday_carry_allocation,
            'holiday_carried' => $data->holiday_carried,
            'sickness_allocation' => $data->sickness_allocation,
            'contact_number' => $data->contact_number,
            'contact_email' => $data->contact_email,
            'started_on' => $data->started_on,
            'finished_on' => $data->finished_on
        ]);
    }
}
