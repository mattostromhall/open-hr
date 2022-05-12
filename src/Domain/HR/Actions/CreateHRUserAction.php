<?php

namespace Domain\HR\Actions;

use Domain\Auth\Actions\CreateUserAction;
use Domain\HR\DataTransferObjects\HRData;
use Domain\HR\DataTransferObjects\HRUserData;

class CreateHRUserAction
{
    public function __construct(protected CreateUserAction $createUser, protected CreateHRAction $createHR)
    {
        //
    }

    public function execute(HRUserData $data): array
    {
        $user = $this->createUser->execute($data->userData);

        $hr = $this->createHR->execute(
            new HRData(user: $user, contact_number: $data->contact_number, contact_email: $data->contact_email)
        );

        return [$user, $hr];
    }
}
