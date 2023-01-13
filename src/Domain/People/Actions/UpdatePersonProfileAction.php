<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\UpdatePersonProfileActionInterface;
use Domain\People\DataTransferObjects\PersonProfileData;
use Domain\People\Models\Person;

class UpdatePersonProfileAction implements UpdatePersonProfileActionInterface
{
    public function execute(Person $person, PersonProfileData $data): bool
    {
        return $person->update([
            'title' => $data->title,
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'initials' => $data->initials,
            'pronouns' => $data->pronouns,
            'dob' => $data->dob,
            'contact_number' => $data->contact_number,
            'contact_email' => $data->contact_email
        ]);
    }
}
