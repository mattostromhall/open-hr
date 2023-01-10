<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\CreateUserAction;
use Domain\People\DataTransferObjects\PersonData;
use Domain\People\DataTransferObjects\PersonUserData;

class CreatePersonUserAction
{
    public function __construct(protected CreateUserAction $createUser, protected CreatePersonAction $createPerson)
    {
        //
    }

    public function execute(PersonUserData $data): array
    {
        $user = $this->createUser->execute($data->user_data);

        $person = $this->createPerson->execute(
            new PersonData(
                user: $user,
                first_name: $data->first_name,
                last_name: $data->last_name,
                dob: $data->dob,
                position: $data->position,
                remuneration: $data->remuneration,
                remuneration_interval: $data->remuneration_interval,
                remuneration_currency: $data->remuneration_currency,
                base_holiday_allocation: $data->base_holiday_allocation,
                sickness_allocation: $data->sickness_allocation,
                contact_number: $data->contact_number,
                contact_email: $data->contact_email,
                started_on: $data->started_on,
                manager: $data->manager,
                department: $data->department,
                title: $data->title,
                initials: $data->initials,
                pronouns: $data->pronouns,
                finished_on: $data->finished_on,
                holiday_carry_allocation: $data->holiday_carry_allocation,
                holiday_carried: $data->holiday_carried
            )
        );

        return [$user, $person];
    }
}
